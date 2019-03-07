<?php
namespace App\Classes;

use App\Model\Vadmin\Core\Vnexpress\AcvIndex;
use Sunra\PhpSimple\HtmlDomParser;

class LaoDongData
{

    public function __construct()
    {

    }
    
    public function getItems($url){
        $html = HtmlDomParser::file_get_html($url);
        $data = [];
        $index = 0;
        $time = time();

        foreach ( $html->find('.list-main-content li .article-large ') as $article) {
            if($article->find('h4 a',0)){
                $item['title']  = $article->find('h4 a ',0)->plaintext;
            }
            if($article->find('p ',1)){
                $item['description'] = $article->find('p ',1)->plaintext;
            }
            if($article->find('h4 a',0)){
                $item['href']    = $article->find('h4 a',0)->href;
                $tmp = explode('/', $item['href']);
                $website = $tmp[2];
                $item['website']= $website;
            }
            if( $article->find('a figure._thumb noscript img', 0) ) {
                $srcImage = $article->find('a figure._thumb noscript img', 0)->src;
                $tmp = explode('?', $srcImage);
                $image = $tmp[0];
                $item['img']= $image;
            } else $item['img']= '';
            $item['Stt']= $index;
            $item['time']= $time;
            $data[] = $item;
            AcvIndex::addItem($item);
            $index++;
        }
        // dd($data);
        return ($data);
    }    

    public function getDetail($url){
        $html = HtmlDomParser::file_get_html($url);
        if($html->find('div.article-content',0)) {
            $data = ($html->find('div.article-content',0));
            return $data;
        } else if($html->find('.body ._photo-content',0)) {
            $data = ($html->find('div.article-content',0));
            return $data;
        }
        
        
    }


}