<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
include("../components/simple_html_dom.php");

class CrawController extends Controller
{
    public function actionIndex() {

    		// $all = isset($_GET['all']) ? $_GET['all'] : '';
    		$blogCode = isset($_GET['blog']) ? $_GET['blog'] : '';
    		$articleCode = isset($_GET['article']) ? $_GET['article'] : '';

				$accountList = array();
				$articleList = array();

				if(!empty($blogCode)){
                    if($blogCode = 'all'){
                        for($code=1; $code<44; $code++){
                            for($i=1; $i<8; $i++){
                                $url = 'https://www.pixnet.net/blog/bloggers/category/'.$code.'/'.$i;
                                $listCmd = $this->getBlogList($url);
                                $accountList = array_merge($accountList, $listCmd);
                            }
                        }
                    }else{
                        for($i=1; $i<8; $i++){
                            $url = 'https://www.pixnet.net/blog/bloggers/category/'.$blogCode.'/'.$i;
                            $listCmd = $this->getBlogList($url);
                            $accountList = array_merge($accountList, $listCmd);
                        }
                    }

					foreach($accountList as $a)
					    echo "http://".$a.".pixnet.net/blog<BR>";
				}

				if(!empty($articleCode)){
                    if($articleCode == 'all'){
                        for($code=1; $code<45; $code++){
                            for($i=1; $i<11; $i++){
                                $url = 'https://www.pixnet.net/blog/articles/category/'.$code.'/hot/'.$i;
                                $listCmd = $this->getArticleList($url);
                                $articleList = array_merge($articleList, $listCmd);
                            } 
                        }
                    }else{
                        for($i=1; $i<11; $i++){
                            $url = 'https://www.pixnet.net/blog/articles/category/'.$articleCode.'/hot/'.$i;
                            $listCmd = $this->getArticleList($url);
                            $articleList = array_merge($articleList, $listCmd);
                        } 
                    }

                    foreach($articleList as $a){
                        $link = explode('post/', $a);
                        echo $link[0]."<BR>";
                    } 
				}

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
