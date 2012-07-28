
//seigyo
var cW=320;
var cH=400;
var onGameStatus=0;
//マウス座標
var mouseX;
var mouseY;
//パラメーター等
var Power;
var addPower;
var removePower;
var Score;
var timeCount;
var imgCount;
var imgEffectCount;
var girlRotationPer;
var moveCount;
var finishCount;
//Canvasの準備
var canvas = document.getElementById("canvas");
var ctx = canvas.getContext("2d");

//読み込み時
function init(){
  backGround = new Image();
  backGround.src = "http://shindan.blamestitch.com/cake/app/webroot/js/png/start.png";
  backGround.onload = function(){
    ctx.drawImage(backGround,0,80);
  }

  headerImg = new Image();
  headerImg.src = "http://shindan.blamestitch.com/cake/app/webroot/js/png/header.png";
  headerImg.onload = function(){
    ctx.drawImage(headerImg,0,0);
  }

  resultImg = new Image();
  resultImg.src = "http://shindan.blamestitch.com/cake/app/webroot/js/png/result.png";
  finishImg = new Image();
  finishImg.src = "http://shindan.blamestitch.com/cake/app/webroot/js/png/finish.png";
  powerImg = new Image();
  powerImg.src = "http://shindan.blamestitch.com/cake/app/webroot/js/png/power.png";
  timeupImg = new Image();
  timeupImg.src = "http://shindan.blamestitch.com/cake/app/webroot/js/png/timeup.png";
}

//マウス座標
/*
canvas.onmousedown = mouseDownListner;
function mouseDownListner(e) {
  var hit_value;
  //マウス座標の取得
  adjustXY(e);
  //画面の動きを抑制
  e.preventDefault();
  if(onGameStatus==1){
    var rand_num = Math.floor(Math.random()*10+1);
    //ゲージを加算させる動き
    Power+=rand_num;
  }else if(onGameStatus==0){
    gameStart();
  }else if(onGameStatus==3){
    gameStart();
  }
}
*/

//------------------------------------
canvas.onmousedown=function(e){
  mDown(e)
  e.preventDefault();
  return false;
}

canvas.ontouchstart=function(){
  e=event.touches[0];
  //１本目の指だけ処理する
  mDown(e)
  event.preventDefault();
  return false;
}

function mDown(e){
  //ここに共通処理
  //e.clientX，e.clientYで位置を取得したりとか
  //alert('aaaaaaa');
  if(onGameStatus==1){
    var rand_num = Math.floor(Math.random()*10+1);
    //ゲージを加算させる動き
    Power+=rand_num;
  }else if(onGameStatus==0){
    gameStart();
  }else if(onGameStatus==3){
    gameStart();
  }
}
//------------------------------------


//スコア上昇_アニメーション
function moveKirakira(){
  if(Power>=80){
    effect_1 = new Image();
    effect_1.src = "http://shindan.blamestitch.com/cake/app/webroot/js/png/star_1.png";
    effect_2 = new Image();
    effect_2.src = "http://shindan.blamestitch.com/cake/app/webroot/js/png/star_2.png";
    effect_3 = new Image();
    effect_3.src = "http://shindan.blamestitch.com/cake/app/webroot/js/png/star_3.png";
    effect_1.onload = function(){
      effect_img = eval("effect_"+ imgEffectCount);
      ctx.drawImage(effect_img,200,190);
    }
    imgEffectCount+=1;
    if(imgEffectCount>3){imgEffectCount=1;}
  }
}

//メインアニメーション
function moveAnimation(){
  moveCount+=1;
  if (moveCount%girlRotationPer==0){
  png_1 = new Image();
  png_1.src = "http://shindan.blamestitch.com/cake/app/webroot/js/png/1.png";
  png_2 = new Image();
  png_2.src = "http://shindan.blamestitch.com/cake/app/webroot/js/png/2.png";
  png_3 = new Image();
  png_3.src = "http://shindan.blamestitch.com/cake/app/webroot/js/png/3.png";
  png_4 = new Image();
  png_4.src = "http://shindan.blamestitch.com/cake/app/webroot/js/png/4.png";
  png_5 = new Image();
  png_5.src = "http://shindan.blamestitch.com/cake/app/webroot/js/png/5.png";
  png_6 = new Image();
  png_6.src = "http://shindan.blamestitch.com/cake/app/webroot/js/png/6.png";
  png_7 = new Image();
  png_7.src = "http://shindan.blamestitch.com/cake/app/webroot/js/png/7.png";
  png_8 = new Image();
  png_8.src = "http://shindan.blamestitch.com/cake/app/webroot/js/png/8.png";
  png_9 = new Image();
  png_9.src = "http://shindan.blamestitch.com/cake/app/webroot/js/png/9.png";
  png_10 = new Image();
  png_10.src = "http://shindan.blamestitch.com/cake/app/webroot/js/png/10.png";
  png_11 = new Image();
  png_11.src = "http://shindan.blamestitch.com/cake/app/webroot/js/png/11.png";
  png_1.onload = function(){
    movie_img = eval("png_"+ imgCount);
    ctx.drawImage(movie_img,0,81);
    if(Power<=10){
      ctx.fillText("START",100,250);
    }
  }
  imgCount+=1;
  if(imgCount>10){imgCount=1;}
  }
}

//スタート時にパラメータをリセット
function gameStart(){
  onGameStatus = 1;
  Power=0;
  addPower=3;
  removePower =1;
  Score=0;
  timeCount =15;
  imgCount=1;
  imgEffectCount=1;
  girlRotationPer=30;
  moveCount = 1;
  finishCount =0;
  //backGround = new Image();
  //backGround.src = "http://shindan.blamestitch.com/cake/app/webroot/js/png/start.png";
  //backGround.onload = function(){
  //  ctx.drawImage(backGround,0,0);
  //}
  interval_1 = setInterval("draw()", 500);
  interval_2 = setInterval("timeManage()",1000);
  interval_3 = setInterval("powerManage()",500);
  interval_5 = setInterval("scoreManage()",200);
  interval_6 = setInterval("moveAnimation()",100);
  interval_7 = setInterval("moveKirakira()",200);
}

//結果画面>ボタン押下で次のゲーム
function nextGame(){
  clearInterval(interval_8);
  onGameStatus =3;
  //一旦全て削除
  ctx.clearRect(0,80,320,400);
  ctx.drawImage(resultImg,0,81);
  ctx.font = "bold 20px 'ＭＳ Ｐゴシック'";
  ctx.fillText("得点は"+Score+"です！",10,130);
  ctx.fillText("ボタン押下して下さい",10,150);
}

/* type:1 timeup type:2 over_power*/
function gameOver(type){
  onGameStatus = 2;
  clearInterval(interval_1);
  clearInterval(interval_2);
  clearInterval(interval_3);
  clearInterval(interval_5);
  clearInterval(interval_6);
  clearInterval(interval_7);
  //一旦全て削除
  ctx.clearRect(0,80,320,400);
  ctx.font = "bold 20px 'ＭＳ Ｐゴシック'";
  if(type==1){
    ctx.drawImage(timeupImg,0,81);
    ctx.fillText("TIME UP!!!!!",10,120);
  }else{
    ctx.drawImage(finishImg,0,81);
    ctx.fillText("OVER POWER!!!!",10,120);
  }
  //５秒程度待って結果画面
  interval_8 = setInterval("finishManage()",1000);
}

//終了から結果まで数秒時間を空ける
function finishManage(){
  finishCount += 1;
  if(finishCount>3){
    nextGame();
  }
}

//時間の管理
function timeManage(){
  timeCount -= 1;
  if(timeCount<0){gameOver(1);}
}

/*スコアの計算*/
function scoreManage(){
  if(Power>=80){
    var addScore = 100-Power;
    Score+=addScore;
  }
}

//パワーの管理
function powerManage(){
  Power -= removePower;
  if(Power<0){
    Power = 0;
  }
  if(Power>100){
    gameOver(2);
  }
}

//呼びだし時にマウス座標を返す関数
function adjustXY(e) {
  var rect = e.target.getBoundingClientRect();
  mouseX = e.clientX - rect.left;
  mouseY = e.clientY - rect.top;
}

function removePower(){
  Power = Power - removePower;
  if(Power < 0){
    Power = 0;
  }
}

/*パラメーターのビュー*/
function draw(){
  ctx.font = "bold 20px 'ＭＳ Ｐゴシック'";
  ctx.clearRect(0,0,320,80);
  ctx.drawImage(headerImg,0,0);
  //ctx.fillText("Power: "+Power,5,20);
  ctx.fillText("Score: "+Score,5,30);
  ctx.fillText("TimeCount:"+timeCount,150,30);
  //ctx.fillText("RotationPer: "+girlRotationPer,5,50);
  ctx.fillText("" +Power,20,50);

  var powerBar = Math.floor(Power);
  for(i=0;i<powerBar;i++){
    ctx.drawImage(powerImg,20+(i*2.5),60);
  }
  //girlRotationPer = Math.floor((-0.14 * Power) +15);
  girlRotationPer = Math.floor(-0.04*Power+5);
  //ctx.fillText("START",100,250);
}
init();
