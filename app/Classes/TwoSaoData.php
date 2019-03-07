<?php
namespace App\Classes;

use App\Model\Vadmin\Core\Vnexpress\AcvIndex;
use Sunra\PhpSimple\HtmlDomParser;

class TwoSaoData
{


    public function __construct()
    {

    }
    
    public function getItems($url){
        $html = HtmlDomParser::file_get_html($url);
        $data = [];
        $index = 0;
        $time = time();
        foreach ( $html->find('.main-list-content .item-article-wrapper.vnnClearfix') as $article) {
            if($article->find('.item-wrap-info h3 a span',1)){
                $item['title']  = $article->find('.item-wrap-info h3 a span',1)->plaintext;
            } else {
                $item['title']  = $article->find('.item-wrap-info h3 a',0)->plaintext;
            }
            if($article->find('.item-wrap-info .mst-desc',0)){
                $item['description'] = $article->find('.item-wrap-info .mst-desc',0)->plaintext;
            }
            if($article->find('.item-wrap-info h3 a',0)){
                $item['href']    = 'https://2sao.vn'.$article->find('.item-wrap-info h3 a',0)->href;
                $tmp = explode('/', $item['href']);
                $website = $tmp[2];
                $item['website']= $website;
            }
            if($article->find('.item-wrap-media a img', 0)) {
                $srcImage = $article->find('.item-wrap-media a img', 0)->src;
                $tmp = explode('?', $srcImage);
                $image = $tmp[0];
                $item['img']= $image;
            }
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
        if($html->find('div.full-desc-detail',0)) {
            $data = ($html->find('div.full-desc-detail',0));
        }
        else {
            $data = ($html->find('div#vmcContent ',0));
        }
        return $data;
    }


}