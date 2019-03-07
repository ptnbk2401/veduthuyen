<?php
namespace App\Classes;
use Sunra\PhpSimple\HtmlDomParser;

class SimpleHTMLDOM
{


    public function __construct()
    {

    }
    
    public static function adayroi($url)
    {
        $url = 'https://www.adayroi.com'.$url;
        $html = HtmlDomParser::file_get_html( $url );
        // Find all article blocks
        // dd($html);
        $articles = array();
        if (!$html) {
            $request->session()->flash('msg', 'Lỗi chọn đường dẫn không hợp lê');
            return view('vadmin.core.product.acpindex.htmldom');
        }
        foreach($html->find('div.product-item') as $article) {
            $item['title']   = $article->find('a.product-item__info-title', 0)->plaintext;
            $item['href']    = $article->find('a.product-item__info-title', 0)->href;
            $item['img']    = $article->find('a.product-item__thumbnail img.default ', 0)->getAttribute('data-src');
            if ($article->find('span.product-item__info-price-original', 0)) {
                $item['giacu'] = $article->find('span.product-item__info-price-original', 0)->plaintext;
                $item['giahientai']   = $article->find('span.product-item__info-price-sale', 0)->plaintext;
            } else {
                $item['giahientai'] = $article->find('span.product-item__info-price-sale', 0)->plaintext;
            }
            $articles[] = $item;
        }
        return $articles;
    }
    public function getDetail($url,$type,$divcontent) {
        $html = HtmlDomParser::file_get_html( 'https://news.zing.vn/the-gioi.html' );
        foreach ($html->find('article.article-item') as $article) {
            $content['title'] = $article->find('p a.article-title', 0)->plaintext;  
        }
            
        return $content;


        if ($type == 'id') {
            $div = '#'.$divcontent;
        } else {
            $div = '.'.$divcontent;
        }
        // Find all article blocks
        $content = '';
        if (!$html) {
            $request->session()->flash('msg', 'Lỗi chọn đường dẫn không hợp lê');
            return $content;
        }
        // return $div;
        
    }


}