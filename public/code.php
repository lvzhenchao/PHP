<?php
    //开启session_start();
    session_start();
    header('content-type:image/jpeg');
    //1、验证码的画布
    $img = imagecreatetruecolor(150,50);

    //1-1，背景颜色 颜色随机
    $bgColor = imagecolorallocate($img,rand(126,255),rand(126,255),rand(126,255));
    //1-2，填充颜色
    imagefill($img,0,0,$bgColor);

    //1-3、画点点
    for($i = 1 ; $i <= 1000 ; $i++){
        //每一次点的x的位置
        $pixX = rand(5,145);
        //每一次点的y的位置
        $pixY = rand(5,45);
        //每一次点的颜色
        $pixColor = imagecolorallocate($img,rand(0,125),rand(0,125),rand(0,125));
        imagesetpixel($img,$pixX,$pixY,$pixColor);
    }
    //2、写字或画画
    $code = '0123456789';
    $contents = '';
    //4个字
    for($j = 0 ; $j <= 3 ; $j++){
        //随机字体大小
        $fontSize = rand(18,25);
        //随机字体的x和y 的位置
        $fontX = ($j + 1) * 25;//(0+1)*25   (1+1)*25 (2+1)*25  (3+1)*25
        $fontY = rand(30,35);
        //随机出来字体的颜色
        $fontColor = imagecolorallocate($img,rand(0,125),rand(0,125),rand(0,125));
        //随机出来的内容
        $content = $code[rand(0,strlen($code)-1)];
        //随机角度
        $fontAngle = rand(0,5);
        imagettftext($img,$fontSize,$fontAngle,$fontX,$fontY,$fontColor,'./arial.ttf',$content);
        $contents .= $content;
    }

    $_SESSION['code'] = $contents;

    //3、输出或保存
    imagejpeg($img);
    //4、释放资源
    imagedestroy($img);
?>
