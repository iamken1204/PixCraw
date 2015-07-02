<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
include("../components/simple_html_dom.php");
use yii\helpers\VarDumper;

class CrawController extends Controller {

    public function actionIndex() {
        return $this->render('view_craw');
    }

    public function actionTest()
    {

        // $html = file_get_html('https://www.pixnet.net/blog/articles/all/0/hot/1');
        // $content = $html->find('#content');

        // $divOne = $content[0]->find('.featured');
        // $a = $divOne[0]->find('a');

        // $r2 = $content[0]->find('.rank-2');
        // $h3 = $r2[0]->find('h3');
        // $a = $h3[0]->find('a');

        // $url = '';
        // foreach ($a as $r) {
        //     if (strpos($r, 'blog/post') !== false) {
        //         $url = $r->href;
        //         break;
        //     }
        // }

        echo "fetching top 100 articles<BR>";
        $baseUrl = 'https://www.pixnet.net/blog/articles/all/0/hot/';
        $urls = [];
        for ($i = 1; $i < 11; $i++) {
            $url = $baseUrl . $i;
            $html = file_get_html($url);
            $content = $html->find('#content');
            $levelStart = $i * 10 - 9;
            $levelEnd = $i * 10;
            for ($ii = $levelStart; $ii <= $levelEnd; $ii++) {
                if ($ii == 1) {
                    $target = $content[0]->find('.featured');
                } else {
                    $target = $content[0]->find(".rank-$ii");
                    $target = $target[0]->find('h3');
                }
                $a = $target[0]->find('a');
                $url = '';
                foreach ($a as $r) {
                    if (strpos($r, 'blog/post') !== false) {
                        $urls[] = $r->href;
                        break;
                    }
                }
            }
        }
        VarDumper::dump($urls, 10, true);
        exit;
    }

    public function actionGetlink() {
        $articleCode = $_GET['artCode'];
        $blogCode = $_GET['bloCode'];

        $accountList = array();
        $articleList = array();

        if(!empty($blogCode)){
            for($i=1; $i<8; $i++){
                $url = 'https://www.pixnet.net/blog/bloggers/group/'.$blogCode.'/'.$i;
                $listCmd = $this->getBlogList($url);
                $accountList = array_merge($accountList, $listCmd);
            }
            foreach($accountList as $idx=>$a)
                $accountList[$idx] = "http://".$a.".pixnet.net/blog";
        }
        if(!empty($articleCode)){
            for($i=1; $i<11; $i++){
                $url = 'https://www.pixnet.net/blog/articles/group/'.$articleCode.'/hot/'.$i;
                $listCmd = $this->getArticleList($url);
                $articleList = array_merge($articleList, $listCmd);
            }
            foreach($articleList as $idx=>$a){
                $link = explode('post/', $a);
                $articleList[$idx] = $link[0];
            }
        }

        $res = [
            'status' => 'ok',
            'accountList' => $accountList,
            'articleList' => $articleList
        ];
        return json_encode($res);
    }

    public function getBlogList($url=null) {

        $list = array();
        if(empty($url))
            return ;
        $html = file_get_html($url);
        foreach($html->find('a') as $key=>$element){
            if(strpos($element->href, '/blog/profile') !== false){
                if($key%2 == 1){
                    $account = str_replace('/blog/profile/', '', $element->href);
                    $list[] = $account;
                }
            }
        }
        return $list;
    }

    public function getArticleList($url=null) {

        $list = array();
        if(empty($url))
            return ;
        $html = file_get_html($url);
        foreach($html->find('a') as $key=>$element){
            if(strpos($element->href, '/blog/post') !== false){
                if(($key+1)%4 == 1){
                    $link = $element->href;
                    $list[] = $link;
                }
            }
        }
        return $list;
    }


}
