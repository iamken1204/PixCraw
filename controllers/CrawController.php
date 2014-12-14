<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
include("../components/simple_html_dom.php");

class CrawController extends Controller {

    public function actionIndex() {
            return $this->render('view_craw');
    }

    public function actionGetlink() {
        $articleCode = $_GET['artCode'];
        $blogCode = $_GET['bloCode'];

        $accountList = array();
        $articleList = array();

        if(!empty($blogCode)){
            for($i=1; $i<8; $i++){
                $url = 'https://www.pixnet.net/blog/bloggers/category/'.$blogCode.'/'.$i;
                $listCmd = $this->getBlogList($url);
                $accountList = array_merge($accountList, $listCmd);
            }
            foreach($accountList as $idx=>$a)
                $accountList[$idx] = "http://".$a.".pixnet.net/blog";
        }
        if(!empty($articleCode)){
            for($i=1; $i<11; $i++){
                $url = 'https://www.pixnet.net/blog/articles/category/'.$articleCode.'/hot/'.$i;
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
