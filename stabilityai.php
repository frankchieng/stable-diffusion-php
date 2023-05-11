<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>stability文字生成图片</title>
    <link rel="stylesheet" href="css/common.css?v1.1">
    <link rel="stylesheet" href="css/wenda.css?v1.1">
    <link rel="stylesheet" href="css/hightlight.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
      <style>
  #custom-handle {
    width: 3em;
    height: 1.6em;
    top: 50%;
    margin-top: -.8em;
    text-align: center;
    line-height: 1.6em;
  }
   #steps-custom-handle {
    width: 3em;
    height: 1.6em;
    top: 50%;
    margin-top: -.8em;
    text-align: center;
    line-height: 1.6em;
  } 
   #height-custom-handle {
    width: 3em;
    height: 1.6em;
    top: 50%;
    margin-top: -.8em;
    text-align: center;
    line-height: 1.6em;
  } 
   #width-custom-handle {
    width: 3em;
    height: 1.6em;
    top: 50%;
    margin-top: -.8em;
    text-align: center;
    line-height: 1.6em;
  } 

   #sample-custom-handle {
    width: 3em;
    height: 1.6em;
    top: 50%;
    margin-top: -.8em;
    text-align: center;
    line-height: 1.6em;
  } 
  </style>
</head>

<body>
    <div class="layout-wrap">
        <header class="layout-header">
            <div class="container" data-flex="main:justify cross:start">
                <div class="header-logo"> 
                    <h2 class="logo"><a class="links" id="pic-intro" title="生成图片说明"><span class="logo-title">图片生成尽量输入英文，中文识别率不太高</span></a></h2>
                </div>  

                <!--<div class="header-logo">
                    <h2 class="logo"><a class='links' id='donate' title='请点击付费'><span class='logo-title'>点击查看额度
                    </span></a></h2>
                </div>-->
            </div>
        </header>
        <div class="layout-content">

            <div class="container">

                <article class="article" id="article">
                    <div class="article-box">

                        <div class="precast-block" data-flex="main:left">
                            <div class="input-group">
                                <span style="text-align: center;color:#9ca2a8">&nbsp;&nbsp;目前文字生成图片等待时间比较长1分钟左右，等待途中不要关闭访问，生成图片后可以长按图片保存到本地，有任何问题可以联系添加管理员微信号：714580106 </span>
                            </div>
                        </div>

     <span style="color:#9ca2a8">引擎选择：</span>
                                <select id="enginelist" style="width:calc(100% - 90px);max-width:180px;">
    <?php
    require_once('config.inc.php');
    foreach($SD_ENGINE_LIST as $engine) {
    ?>
        <option value="<?php echo $engine;?>"><?php echo $engine;?></option>
    <?php
    }
    ?>
                                </select>

    <span style="color:#9ca2a8">采样器：</span>
    <select id="samplerlist" style="width:calc(100% - 90px);max-width:180px;">
    <?php
    require_once('config.inc.php');
    foreach($SD_SAMPLER as $sampler) {
    ?>
        <option value="<?php echo $sampler;?>"><?php echo $sampler;?></option>
    <?php
    }
    ?>
    </select>

     <span style="color:#9ca2a8;margin-bottom:5px;">图片高度:(像素值，768引擎的值要求在768以上):&nbsp;&nbsp;</span>
      <input type="hidden" id="sd_height">
     <div id="heightslider" style="display:inline-block;width:calc(100% - 90px);max-width:180px;">
  <div id="height-custom-handle" class="ui-slider-handle"></div>
</div>

     <span style="color:#9ca2a8;margin-bottom:5px;">图片宽度:(像素值，768引擎的值要求在768以上):&nbsp;&nbsp;</span>
      <input type="hidden" id="sd_width">
     <div id="widthslider" style="width:calc(100% - 90px);max-width:180px;">
  <div id="width-custom-handle" class="ui-slider-handle"></div>
</div>

     <span style="color:#9ca2a8;margin-top:5px;margin-bottom:5px;">Cfg Scale:(值越高，生成的图片越吻合你的描述)</span>
      <input type="hidden" id="cfgscale">
     <div id="slider" style="width:calc(100% - 90px);max-width:350px;margin-top:5px;margin-bottom:5px;">
  <div id="custom-handle" class="ui-slider-handle"></div>
</div>
     <span style="color:#9ca2a8;margin-top:5px;margin-bottom:5px;">Steps:(影响画面的完成度，值越高，越会在后面的步数中倾向于渲染细节,步数越高生成图片速度越慢，建议50以下)</span>
      <input type="hidden" id="steps">
     <div id="stepslider" style="width:calc(100% - 90px);max-width:350px;margin-top:5px;margin-bottom:5px;">
  <div id="steps-custom-handle" class="ui-slider-handle"></div>
</div>

      <span style="color:#9ca2a8;margin-top:5px;margin-bottom:5px;">Seed:(种子值，0生成随机种子数):&nbsp;&nbsp;</span>
        <input id="spinner" name="value">

     <span style="color:#9ca2a8;margin-top:5px;margin-bottom:5px;">生成图片数量:</span>
      <input type="hidden" id="samples">
     <div id="sampleslider" style="width:calc(100% - 90px);max-width:180px;margin-top:5px;margin-bottom:5px;">
  <div id="sample-custom-handle" class="ui-slider-handle"></div>
</div>
                        <ul id="article-wrapper">

                        </ul>
                        <div class="creating-loading" data-flex="main:center dir:top cross:center">
                            <div class="semi-circle-spin"></div>
                        </div>
                        <div id="fixed-block">
                            <div class="precast-block" id="kw-target-box" data-flex="main:left cross:center">
                                <div id="target-box" class="box">
                                    <textarea name="kw-target" placeholder="在此提问生成图片" id="ai-pic-target" autofocus rows=1></textarea>
                                </div>
                                <div class="right-btn layout-bar">
                                    <p class="btn ai-btn bright-btn" id="ai-pic-btn" data-flex="main:center cross:center"><i class="iconfont icon-wuguan"></i>发送</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.cookie.min.js"></script>
    <script src="js/layer.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/jquery.mousewheel.js"></script>
    <script src="js/chat.js"></script>
    <script src="js/highlight.min.js"></script>
    <script src="js/showdown.min.js"></script>
    <script>
  $( function() {
    var handle = $( "#custom-handle" );
    $( "#slider" ).slider({
      range: "max",
      min: 0,
      max: 35,
      value: 7,
      create: function() {
        handle.text( $( this ).slider( "value") );
         $("#cfgscale").val($( this ).slider( "value"));
      },
      slide: function( event, ui ) {
        handle.text( ui.value );
        $("#cfgscale").val( ui.value );
      }
    });

    var stephandle = $( "#steps-custom-handle" );
    $( "#stepslider" ).slider({
      range: "max",
      min: 0,
      max: 150,
      value: 30,
      create: function() {
        stephandle.text( $( this ).slider( "value") );
         $("#steps").val($( this ).slider( "value"));
      },
      slide: function( event, ui ) {
        stephandle.text( ui.value );
        $("#steps").val( ui.value );
      }
    });

    var heighthandle = $( "#height-custom-handle" );
    $( "#heightslider" ).slider({
      range: "max",
      min:512,
      max: 1024,
      value: 512,
      step: 64,
      create: function() {
        heighthandle.text( $( this ).slider( "value") );
         $("#sd_height").val($( this ).slider( "value"));
      },
      slide: function( event, ui ) {
        heighthandle.text( ui.value );
        $("#sd_height").val( ui.value );
      }
    });

    var widthhandle = $( "#width-custom-handle" );
    $( "#widthslider" ).slider({
      range: "max",
      min:512,
      max: 1024,
      value: 512,
      step: 64,
      create: function() {
        widthhandle.text( $( this ).slider( "value") );
         $("#sd_width").val($( this ).slider( "value"));
      },
      slide: function( event, ui ) {
        widthhandle.text( ui.value );
        $("#sd_width").val( ui.value );
      }
    });

    var spinner = $( "#spinner" ).spinner({
      spin: function( event, ui ) {
        if ( ui.value > 4294967295 ) {
          $( this ).spinner( "value", 0 );
          return false;
        } else if ( ui.value < 0 ) {
          $( this ).spinner( "value", 0 );
          return false;
        }
      }
    });
     spinner.spinner( "value", 0 );

    var samplehandle = $( "#sample-custom-handle" );
    $( "#sampleslider" ).slider({
      range: "max",
      min: 1,
      max: 4,
      value: 1,
      create: function() {
        samplehandle.text( $( this ).slider( "value") );
         $("#samples").val($( this ).slider( "value"));
      },
      slide: function( event, ui ) {
        samplehandle.text( ui.value );
        $("#samples").val( ui.value );
      }
    });

  } );
    </script>
</body>

</html>