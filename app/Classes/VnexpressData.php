<?php
namespace App\Classes;

use App\Model\Vadmin\Core\Vnexpress\AcvIndex;
use Sunra\PhpSimple\HtmlDomParser;

class VnexpressData
{


    public function __construct()
    {

    }
    
    public function getItems($url){
        $html = HtmlDomParser::file_get_html($url);
        $data = [];
        $index = 0;
        $time = time();
        // echo($html->find('section.sidebar_1 .content_detail',0));
        foreach ( $html->find('.sidebar_1 .list_news') as $article) {
            $item['title']  = $article->find('h4.title_news a',0)->plaintext;
            if($article->find('p.description',0)) {
                $item['description']  = $article->find('p.description',0)->plaintext;
            }else {
                $item['description']  = $item['title'];
            }
            if( $article->find('h4.title_news a', 0) ){
                $item['href']    = $article->find('h4.title_news a', 0)->href;
                $tmp = explode('/', $item['href']);
                $website = $tmp[2];
                $item['website']= $website;
            }
            
            if($article->find('img', 0)->getAttribute('data-original')) {
                $srcImage = $article->find('img', 0)->getAttribute('data-original');
                if(strpos($srcImage,'_300x180')){
                    $srcImage = str_replace('_300x180', '', $srcImage);
                } else if(strpos($srcImage,'_180x108')){
                    $srcImage = str_replace('_180x108', '', $srcImage);
                }
                $item['img']= $srcImage;
            }
            
            // $item['detail']= $this->getDetail( $item['href']);
            $item['Stt']= $index;
            $item['time']= $time;
            $data[] = $item;
            AcvIndex::addItem($item);
            $index++;
        }
        return ($data);
    }    

    public function getDetail($url){
        $html = HtmlDomParser::file_get_html($url);
        if($html->find('section.sidebar_1 .content_detail',0)) {
            $data = ($html->find('section.sidebar_1 .content_detail',0));
        }
        else {
            $data = ($html->find('div.fck_detail ',0));
        }
        return $data;
    }


}