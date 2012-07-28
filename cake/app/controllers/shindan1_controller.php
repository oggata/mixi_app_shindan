<?php

require_once '/var/www/html/shindan/cake/app/controllers/components/spyc.php';

class Shindan1Controller extends AppController{

  var $uses = array('Element');

  function top(){

  }

  function page(){
    $yml_array = Spyc::YAMLLoad('/var/www/html/shindan/cake/app/vendors/yaml/shindan1.yml');

    $score = $_REQUEST["score"];
    $all_score = $_REQUEST["all_score"];
    $all_score = $all_score + $score;
    //page1～page10
    $page_name = $_REQUEST["next_page_name"];
    if($page_name == 'result'){
      $this->redirect('/shindan1/result/'.$all_score);
    }
    $page_no = (int)str_replace('page','',$page_name);
    $this_page_no = $page_no;
    $page_no+=1;
    $next_page_name="page".$page_no;
    $i = 0;
    foreach($yml_array["answer_$this_page_no"] as $answer_data){
      $answers[$i]['txt'] = $answer_data['txt'];
      $answers[$i]['name'] = $answer_data['name'];
      $answers[$i]['score'] = $answer_data['score'];
      $i+=1;
    }
    //view
    $this->set('answers',$answers);
    $this->set('q_txt',$yml_array["question_$this_page_no"]);
    $this->set('page_name',$page_name);
    if($page_no==11){
      $next_page_name = 'result';
    }
    $this->set('next_page_name',$next_page_name);
    $this->set('all_score',$all_score);
    $this->render($layout=page,$file='default');
  }

  function result($all_score){
    $yml_array = Spyc::YAMLLoad('/var/www/html/shindan/cake/app/vendors/yaml/shindan1.yml');
    foreach($yml_array["result"] as $result_data){
      $score = $result_data['score'];
      if($all_score>=$score){
        $titles = $result_data['titles'];
        $txt = $result_data['txt'];
        $lv = $result_data['lv'];
        $imgno =  $result_data['imgno'];
      }
    }
    //view
    $this->set('titles',$titles);
    $this->set('txt',$txt);
    $this->set('lv',$lv);
    $this->set('imgno',$imgno);
  }

  function minigame(){
  }

  function smart_top(){}

  function smart_page($page_name){
    $yml_array = Spyc::YAMLLoad('/var/www/html/shindan/cake/app/vendors/yaml/shindan1.yml');
    if($page_name == 'page1'){
      $account_id = $this->params['form']['id'];
      $all_score = 0;
    }else{
      $add_score = $this->params['data']['score'];
      $session_data = $this->Session->read('SessionData');
      if(strlen($session_data['score'])==0){$this->redirect('/shindan1/top/');}
      $all_score = $session_data['score'];
      $all_score = $all_score + $add_score;
      $account_id = $session_data['account_id'];
    }
    if($page_name == 'result'){
      $this->redirect('/shindan1/smart_result/score:'.$all_score.'/account_id:'.$account_id);
    }
    $page_no = (int)str_replace('page','',$page_name);
    $this_page_no = $page_no;
    $page_no+=1;
    $next_page_name="page".$page_no;
    $i = 0;
    foreach($yml_array["answer_$this_page_no"] as $answer_data){
      $answers[$i]['txt'] = $answer_data['txt'];
      $answers[$i]['name'] = $answer_data['name'];
      $answers[$i]['score'] = $answer_data['score'];
      $i+=1;
    }
    //view
    $this->set('answers',$answers);
    $this->set('q_txt',$yml_array["question_$this_page_no"]);
    $this->set('page_name',$page_name);
    if($page_no==11){
      $next_page_name = 'result';
    }
    $this->set('next_page_name',$next_page_name);
    $this->set('all_score',$all_score);
    //score
    $session_data['score'] = $all_score;
    $session_data['account_id'] = $account_id;
    //session
    $this->Session->write('SessionData',$session_data);
  }

  function smart_result(){
    $all_score = $this->params['named']['score'];
    $account_id = $this->params['named']['account_id'];
    $yml_array = Spyc::YAMLLoad('/var/www/html/shindan/cake/app/vendors/yaml/shindan1.yml');
    foreach($yml_array["result"] as $result_data){
      $score = $result_data['score'];
      if($all_score>=$score){
        $titles = $result_data['titles'];
        $txt = $result_data['txt'];
        $lv = $result_data['lv'];
        $imgno =  $result_data['imgno'];
      }
    }
    //view
    $this->set('account_id',$account_id);
    $this->set('titles',$titles);
    $this->set('txt',$txt);
    $this->set('lv',$lv);
    $this->set('imgno',$imgno);
  }

  function smart_invite(){}

  function session_lost(){}

  function session_manage(){
    $session_data = $this->Session->read("member_info");
    $this->session_data = $session_data;
    if(strlen($session_data['member_code'])==0){
      $this->redirect('/login/session_timeout/');
    }
  }
}