<?php
    function myImages($fileName,$nWidth,$nHeight){
        //1、获得具体要执行的函数名以及图片的一些信息
        $infos = getimagesize($fileName);
        //类型的数组
        $types = array(1=>'gif',2=>'jpeg','3'=>'png');
        $type = $types[$infos[2]];//具体是什么类型的图片//$types[1]   gif
        //要调用的创建的函数
        $create = 'imagecreatefrom'.$type;
        $outPut = 'image'.$type;
        //创建老图片资源
        $oImg = $create($fileName);
        //进行等比例缩放
        if($nWidth && ($infos[0] < $infos[1])){
            $nWidth = ($nHeight / $infos[1]) * $infos[0];
        }else{
            $nHeight = ($nWidth / $infos[0]) * $infos[1];
        }
        //创建新图片资源
        $nImg = imagecreatetruecolor($nWidth,$nHeight);
        //2、执行了缩放的函数
        imagecopyresampled($nImg,$oImg,0,0,0,0,$nWidth,$nHeight,$infos[0],$infos[1]);
        //3、将要保存的文件名进行处理
        //保存图片
        $fileInfos = explode('/',$fileName);//./abc.jpg    C:/xampp/htdocs/153/20160706/abc.jpg
        //得到了纯纯的文件名
        $oldFileName = array_pop($fileInfos);//abc.jpg abc.jpg.gif   explode .
        //得到了纯纯的文件名和后缀名
        $newFileInfos = explode('.',$oldFileName);
        //新生成的文件名
        $newFileName = $newFileInfos[0].'_s'.'.'.array_pop($newFileInfos);
		//获取生成文件路径
		echo $newFileName;
        //生成文件
        $outPut($nImg,'/update/'.$newFileName);
        //销毁资源
        imagedestroy($nImg);
        imagedestroy($oImg);
    }
    myImages('IMG_9720.JPG',100,100);
?>
