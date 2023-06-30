<?php

namespace App\Services;

use App\Models\Bouteille;
use App\Models\Type;
use Symfony\Component\DomCrawler\Crawler;
use stdClass;
use DOMDocument;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpClient\HttpClient;



class SAQService 
{
    const DUPLICATION = 'duplication';
    const ERREURDB = 'erreurdb';
    const INSERE = 'Nouvelle bouteille insérée';

    private static $_webpage;
    private static $_status;

    /**
     * getProduits
     * @param int $nombre
     * @param int $page
     * @return int
     */
    public function getProduits($nombre= 48 ,$page)
    {
        $s = curl_init(); 
        $url = "https://www.saq.com/fr/produits/vin?p=" . $page . "&product_list_limit=" . $nombre . "&product_list_order=name_asc";

       
       
      curl_setopt_array($s,array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_USERAGENT=> 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0',
        CURLOPT_ENCODING=> 'gzip, deflate',
        CURLOPT_HTTPHEADER=>array(
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
					/* Qu'on accepte ce type de contenu pour la réponse, le q est pour la qualité  */
                    'Accept-Language: en-US,en;q=0.5',
					/* On veut que la réponse soit en en-US, en(english) générique et préférence de qualité 0.5 */
                    'Accept-Encoding: gzip, deflate',
					/* Qu'on accepte ce type d'encodage */
                    'Connection: keep-alive',
					/* La connexion TCP doit être maintenu ouverte apres la reponse, afin de pouvoir réutilisé pour des requêtes ultérieures */
                    'Upgrade-Insecure-Requests: 1',
					/* MEttre http à https pour les ressources qui supporte https, la valeur 1 indique que le client est prêt à effectuer cette mise à niveau */
        ),
      ));

        self::$_webpage = curl_exec($s);
        self::$_status = curl_getinfo($s, CURLINFO_HTTP_CODE);
        curl_close($s);

       $doc = new DOMDocument();
       $doc->recover = true;
       $doc->strictErrorChecking = false;
        @$doc->loadHTML(self::$_webpage);
       $elements = $doc->getElementsByTagName('li');

       foreach ($elements as $key=>$noeud) {
        if (strpos($noeud -> getAttribute('class'), "product-item") !== false) {
            $info = self::recupereInfo($noeud);
            $result = $this->ajouteProduit($info);
            $resultData = [
                'nom' => $info->nom,
                'retour' => [
                    'succes' => $result->succes,
                    'raison' => $result->raison,
                ],
            ];
            
            $results[] = $resultData;
            
        }
       }
        
        return new JsonResponse($results);
    }

    private function get_inner_html($node) {
		$innerHTML = '';
		$children = $node -> childNodes;
		foreach ($children as $child) {
			$innerHTML .= $child -> ownerDocument -> saveXML($child);
		}

		return $innerHTML;
	}


    private function nettoyerEspace($chaine)
	{
		return preg_replace('/\s+/', ' ',$chaine);
	}


    private function recupereInfo($noeud)
    {
        $info = new stdClass();
        $info -> img = $noeud -> getElementsByTagName("img") -> item(0) -> getAttribute('src');
        $a_titre = $noeud -> getElementsByTagName("a") -> item(0);
		$info -> url = $a_titre->getAttribute('href');

        $nom = $noeud -> getElementsByTagName("a")->item(1)->textContent;

		$info -> nom = self::nettoyerEspace(trim($nom));

        $aElements = $noeud -> getElementsByTagName("strong");
		foreach ($aElements as $node) {
			if ($node -> getAttribute('class') == 'product product-item-identity-format') {
				$info -> desc = new stdClass();
				$info -> desc -> texte = $node -> textContent;
				$info->desc->texte = self::nettoyerEspace($info->desc->texte);
				$aDesc = explode("|", $info->desc->texte); // Type, Format, Pays
				if (count ($aDesc) == 3) {
					
					$info -> desc -> type = trim($aDesc[0]);
					$info -> desc -> format = trim($aDesc[1]);
					$info -> desc -> pays = trim($aDesc[2]);
				}
				
				$info -> desc -> texte = trim($info -> desc -> texte);
				/* var_dump($info->desc->texte); */
			}
		}

        //Code SAQ
		$aElements = $noeud -> getElementsByTagName("div");
		foreach ($aElements as $node) {
			if ($node -> getAttribute('class') == 'saq-code') {
				if(preg_match("/\d+/", $node -> textContent, $aRes))
				{
					$info -> desc -> code_SAQ = trim($aRes[0]);
				}
				
				
				
			}
		}

        $aElements = $noeud -> getElementsByTagName("span");
		foreach ($aElements as $node) {
			if ($node -> getAttribute('class') == 'price') {
				$prix= trim($node -> textContent);
                $prix_nettoyer = str_replace("$","",$prix);
                $prix_point= str_replace(',',".",$prix_nettoyer);
                $info->prix = floatval($prix_point);
                
                
			}
		}
		//var_dump($info);
		return $info;
        
    }



    private function ajouteProduit($bte)
    {
        $retour = new stdClass();
        $retour->succes = false;
        $retour->raison = '';

        $type = Type::where('type', $bte->desc->type)->first();

        if ($type) {
            $rows = Bouteille::where('code_saq', $bte->desc->code_SAQ)->count();

            if ($rows < 1) {
                $nouvelleBouteille = new Bouteille();
                $nouvelleBouteille->nom = $bte->nom;
                $nouvelleBouteille->type = $type->id;
                $nouvelleBouteille->image = $bte->img;
                $nouvelleBouteille->code_saq = $bte->desc->code_SAQ;
                $nouvelleBouteille->pays = $bte->desc->pays;
                $nouvelleBouteille->description = $bte->desc->texte;
                $nouvelleBouteille->prix_saq = $bte->prix;
                $nouvelleBouteille->url_saq = $bte->url;
                $nouvelleBouteille->url_img = $bte->img;
                $nouvelleBouteille->format = $bte->desc->format;

                $retour->succes = $nouvelleBouteille->save();
                $retour->raison = self::INSERE;
            } else {
                $retour->succes = false;
                $retour->raison = self::DUPLICATION;
            }
        } else {
            $retour->succes = false;
            $retour->raison = self::ERREURDB;
        }

        return $retour;
    }

    public function fetchProduit()
    {
        $pages = 345;
        $perPage = 24;
        $currentPage = 1;
    
        set_time_limit(0); // Disable script execution time limit
    
        while ($currentPage <= $pages) {
            $this->getProduits($perPage, $currentPage);
            $currentPage++;
    
            // Optionally, add a delay between iterations to avoid overwhelming the server
            usleep(100000); // Sleep for 100 milliseconds (adjust the delay as needed)
        }
    }

    
}
