<?php
/**
 * DokuWiki Default Template
 *
 * This is the template you need to change for the overall look
 * of DokuWiki.
 *
 * You should leave the doctype at the very top - It should
 * always be the very first line of a document.
 *
 * @link   http://dokuwiki.org/templates
 * @author Andreas Gohr <andi@splitbrain.org>
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $conf['lang']?>"
 lang="<?php echo $conf['lang']?>" dir="<?php echo $lang['direction']?>">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>
    <?php tpl_pagetitle()?>
    [<?php echo strip_tags($conf['title'])?>]
  </title>

  <?php tpl_metaheaders()?>
  <?php echo tpl_favicon(array('favicon', 'mobile')) ?>

  <?php /*old includehook*/ @include(dirname(__FILE__).'/meta.html')?>

<!-- Google Analytics -->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-35105820-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>

<body>
<?php /*old includehook*/ @include(dirname(__FILE__).'/topheader.html')?>
<div class="dokuwiki">
  <?php html_msgarea()?>

  <div class="stylehead">

    <div class="header">
<div id="wikiheader">
	<ul class="links">
		<li class="first"><a href="http://www.ubuntu.cz" title="Ubuntu.cz">Ubuntu.cz</a></li>
		<li><a href="http://wiki.ubuntu.cz/" title="Wiki návody">Wiki návody</a></li>
		<li><a href="http://forum.ubuntu.cz/" title="Fórum">Fórum</a></li>
		<li><a href="http://blog.ubuntu.cz" title="">Blog</a></li>
		<li class="last"><a href="http://komunita.ubuntu.cz" title="">Komunita</a></li>
		<div class="min-search"><?php tpl_searchform();?></div>
		<div id="logo"> <a href="http://wiki.ubuntu.cz" title=""> <img src="/lib/tpl/ubuntucz-wiki-theme/images/logo.png" alt=""></a></div>
	</ul>
</div>
      <div class="clearer"></div>
    </div>

    <?php /*old includehook*/ @include(dirname(__FILE__).'/header.html')?>


    <div class="bar" id="bar__top">
      <div class="bar-left" id="bar__topleft">
        <?php tpl_button('edit')?>
        <?php tpl_button('media')?>
        <?php tpl_select_actions()?>
      </div>

      <div class="bar-right" id="bar__topright">
        <span id="user"><?php if ($_SERVER['REMOTE_USER']) print '<a href="/users/'.$_SERVER['REMOTE_USER'].'">'.$INFO['userinfo']['name'].'</a>'?></span>
        <?php tpl_button('profile')?>
        <?php tpl_button('admin')?>
        <?php tpl_button('login')?>
        <?php tpl_button('recent')?>
      </div>

      <div class="clearer"></div>
    </div>

    <?php if($conf['breadcrumbs']){?>
    <div class="breadcrumbs">
      <?php tpl_breadcrumbs()?>
      <?php //tpl_youarehere() //(some people prefer this)?>
    </div>
    <?php }?>

    <?php if($conf['youarehere']){?>
    <div class="breadcrumbs">
      <?php tpl_youarehere() ?>
    </div>
    <?php }?>

  </div>
  <?php tpl_flush()?>

  <?php /*old includehook*/ @include(dirname(__FILE__).'/pageheader.html')?>

  <div class="page">
    <!-- wikipage start -->
    <?php tpl_content()?>
    <!-- wikipage stop -->
  </div>

  <div class="clearer"></div>

  <?php tpl_flush()?>

  <div class="stylefoot">

    <div class="meta">
      <div class="user">
        <?php tpl_userinfo()?>
      </div>
      <div class="doc">
        <?php 
        if ($INFO['user']) {
         global $auth;
        	$userinfo = $auth->getUserData($INFO['user']);
        	print 'Poslední úprava: '.dformat($INFO['lastmod']).', autor: <a href="/users/'.$INFO['user'].'">'.$userinfo['name'].'</a>';
        	}
        else tpl_pageinfo(); ?>
      </div>
    </div>

   <?php /*old includehook*/ @include(dirname(__FILE__).'/pagefooter.html')?>

    <div class="bar" id="bar__bottom">

      <div class="clearer"></div>
    </div>

  </div>

  <div class="footerinc">

<div id="copy">Logo Ubuntu, Ubuntu a Canonical jsou registrované obchodní známky firmy Canonical Ltd.</div>
<div id="link"><a href="/Licence">Licence</a> | <a href="/Autoři">Autoři</a></div>

</div>

</div>
<?php /*old includehook*/ @include(dirname(__FILE__).'/footer.html')?>

<div class="no"><?php /* provide DokuWiki housekeeping, required in all templates */ tpl_indexerWebBug()?></div>
</body>
</html>

<?php /**
 * Create actions select box
 *
 * Create actions select box.
 *
 * @author Kirill Bezrukov <kirbez@mail.ru>
 */
function tpl_select_actions(){
  global $ID;
  global $INFO;
  global $REV;
  global $ACT;
  global $conf;
  global $lang;
  global $auth;
 
	if($ACT == 'show' || $ACT == 'search'){
		if($INFO['writable']){
			if($INFO['exists']){
			  print '<select class="edit" name="actionmenu" onchange=
						"if ((this.selectedIndex != 0) &&
								(this.options[this.selectedIndex].disabled == false)) {
							location.href = this.options[this.selectedIndex].value;
						}
			            this.selectedIndex = 0;" >'. DOKU_LF;	
				print '  <option value="show">Další akce:</option>'.DOKU_LF;
				print '  <option value="'.wl($ID,'do=export_raw').'">Zdrojový kód</option>'. DOKU_LF;
			        print '  <option value="'.wl($ID,'do=export_xhtml').'">HTML export</option>'. DOKU_LF;	        
			        print '  <option value="show" disabled="disabled" class="disabled">--------------</option>'. DOKU_LF;
			        print '  <option value="'.wl($ID,'purge=true').'">Smazat cache</option>'. DOKU_LF;
				print '  <option value="'.wl($ID,'do=admin&page=acl').'">ACL</option>'. DOKU_LF;
			print '  <option value="show" disabled="disabled" class="disabled">--------------</option>'. DOKU_LF;		
			print '  <option value="'.wl($ID,'do=revisions').'">Starší verze</option>'. DOKU_LF;
			print '  <option value="'.wl($ID,'do=subscribe').'">Odebírat změny</option>'. DOKU_LF;
				print '</select>';	
		  }
		}
	}
 
  return true;
}?>
