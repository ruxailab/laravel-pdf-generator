<!DOCTYPE html>
<html>
<head>
    <title>Final Report</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
.orange-bar {
    background-color: orange;
    height: 20px;
    width: 100%;
  }
        .content {
    padding: 20px;
    color: white;
    font-family: Arial, sans-serif;
    font-size: 16px;
    line-height: 1.5;
    text-align: justify;
}
.content h1{
    color:orange !important; 
    padding: 0px !important;
    margin: 0px !important;
}
        #footer { position: fixed; right: 10px; bottom: 10px; text-align: center;}
        #footer .page:after { content: counter(page, decimal); }
 		@page { margin: 20px 30px 40px 50px; }
    </style>
</head>
<body>
    <div class="content">
        <div class="orange-bar"></div>
        <h1>FINAL REPORT</h1>
        <?php
      

        // Example inner HTML object
        $innerHTML = '<div style="text-align: justify;"><i style="color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;"><b>Samurai</b></i><span style="color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;">&nbsp;(<span class="t_nihongo_kanji" lang="ja">侍</span>&nbsp;<span class="t_nihongo_romaji"><i>samurai</i></span><span class="t_nihongo_help"><sup style="line-height: 1; font-size: 11.2px;"><a href="https://pt.wikipedia.org/wiki/Ajuda:Japon%C3%AAs" title="Ajuda:Japonês" style="text-decoration-line: none; color: rgb(51, 102, 204); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; overflow-wrap: break-word;"><span class="t_nihongo_icon" style="color: darkblue; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-weight: bold; font-stretch: normal; font-size: 8.96px; line-height: normal; font-family: sans-serif; padding-right: 0.1em; padding-left: 0.1em;">?</span></a></sup></span>, em português "servo", masculino)</span><span style="color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;">&nbsp;ou&nbsp;</span><i style="color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;"><b>Bushi</b></i><span style="color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;">&nbsp;(<span class="t_nihongo_kanji" lang="ja">武士</span><span class="t_nihongo_help"><sup style="line-height: 1; font-size: 11.2px;"><a href="https://pt.wikipedia.org/wiki/Ajuda:Japon%C3%AAs" title="Ajuda:Japonês" style="text-decoration-line: none; color: rgb(51, 102, 204); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; overflow-wrap: break-word;"><span class="t_nihongo_icon" style="color: darkblue; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-weight: bold; font-stretch: normal; font-size: 8.96px; line-height: normal; font-family: sans-serif; padding-right: 0.1em; padding-left: 0.1em;">?</span></a></sup></span>&nbsp;em português "guerreiro")</span><span style="color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;">&nbsp;e&nbsp;</span><i style="color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;"><b><a href="https://pt.wikipedia.org/wiki/Onna-bugeisha" title="Onna-bugeisha" style="text-decoration-line: none; color: rgb(51, 102, 204); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; overflow-wrap: break-word;">Onna-bugeisha</a></b></i><span style="color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;">&nbsp;(<span class="t_nihongo_kanji" lang="ja">女武芸者</span><span class="t_nihongo_help"><sup style="line-height: 1; font-size: 11.2px;"><a href="https://pt.wikipedia.org/wiki/Ajuda:Japon%C3%AAs" title="Ajuda:Japonês" style="text-decoration-line: none; color: rgb(51, 102, 204); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; overflow-wrap: break-word;"><span class="t_nihongo_icon" style="color: darkblue; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-weight: bold; font-stretch: normal; font-size: 8.96px; line-height: normal; font-family: sans-serif; padding-right: 0.1em; padding-left: 0.1em;">?</span></a></sup></span>&nbsp;, feminino)</span><span style="color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;">, Inicialmente era um servidor civil do império&nbsp;</span><a href="https://pt.wikipedia.org/wiki/Jap%C3%A3o" title="Japão" style="background: none rgb(255, 255, 255); text-decoration-line: none; color: rgb(51, 102, 204); overflow-wrap: break-word; font-family: sans-serif; font-size: 14px;">japonês</a><span style="color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;">, com as funções de cobrador de&nbsp;</span><a href="https://pt.wikipedia.org/wiki/Impostos" class="mw-redirect" title="Impostos" style="background: none rgb(255, 255, 255); text-decoration-line: none; color: rgb(51, 102, 204); overflow-wrap: break-word; font-family: sans-serif; font-size: 14px;">impostos</a><span style="color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;">&nbsp;(coletoria) e administrador de terras (</span><a href="https://pt.wikipedia.org/wiki/Daimy%C5%8D" class="mw-redirect" title="Daimyō" style="background: none rgb(255, 255, 255); text-decoration-line: none; color: rgb(51, 102, 204); overflow-wrap: break-word; font-family: sans-serif; font-size: 14px;">daimyō</a><span style="color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;">).</span></div><div style="text-align: justify;"><span style="color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;"><br></span></div><div style="text-align: center;"><span style="color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;">Durante o período do Japão feudal, ganhou funções militares e virou um&nbsp;</span><a href="https://pt.wikipedia.org/wiki/Soldado" title="Soldado" style="background: none rgb(255, 255, 255); text-decoration-line: none; color: rgb(51, 102, 204); overflow-wrap: break-word; font-family: sans-serif; font-size: 14px;">soldado</a><span style="color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;">&nbsp;da&nbsp;</span><a href="https://pt.wikipedia.org/wiki/Aristocracia" title="Aristocracia" style="background: none rgb(255, 255, 255); text-decoration-line: none; color: rgb(51, 102, 204); overflow-wrap: break-word; font-family: sans-serif; font-size: 14px;">aristocracia</a><span style="color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;">&nbsp;imperial, no período de 930 a 1877, terminando a era como um ronin duelista (samurai desonrado) ou mestre de artes, como artesanato, pintura, ou de chá.</span></div>';

        // Output the inner HTML object
        echo $innerHTML;
        ?>
    </div>
	<div id="footer">

    </body>
</html>
