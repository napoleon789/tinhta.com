<div id="container" class="clearfix">
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <header id="header" role="banner" class="clearfix">
  <div class="top_page">
  <div id ="logo_top">
	<?php if ($logo): ?>
      <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" id="logo">
        <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
      </a>
    <?php endif; ?>
    <?php if ($site_name || $site_slogan): ?>
      <hgroup id="site-name-slogan">
        <?php if ($site_name): ?>
          <h3 id="site-name">
            <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>"><span><?php print $site_name; ?></span></a>
          </h3>
        <?php endif; ?>
        <?php if ($site_slogan): ?>
          <h2 id="site-slogan"><?php print $site_slogan; ?></h2>
        <?php endif; ?>
      </hgroup>
    <?php endif; ?>
	<div class='right'>
				<form action="http://tinhta.com/search.php" id="cse-search-box"  >
					<input name="cx" type="hidden" value="017101863045785825134:nikeqj1akka " />
					<input name="cof" type="hidden" value="FORID:20" />
					<input name="ie" type="hidden" value="UTF-8" />
					<input id="searchbox" name="q" 
						onblur="if(this.value=='')this.value=this.defaultValue;" 
						onfocus="if(this.value==this.defaultValue)this.value='';" 
						size="30" type="text" 
						value="Nhập từ khóa tìm kiếm..." />
				</form>
			</div>
			<div class="user">
	<?php
	global $user;
	if($user->uid >0)
	{
	print l($user->name,'user/'.$user->uid);
	echo ' | ';
	print l('Logout','user/logout');
	}
	?>
	</div>
    </div>
    <?php print render($page['header']); ?>
</div>
  </header> <!-- /#header -->
  <section id="main" role="main" class="clearfix">
  <div class="padding">
  <!--   <?php if ($breadcrumb): print $breadcrumb; endif;?> -->
    <?php print $messages; ?>
    <a id="main-content"></a>
    <?php if ($page['highlighted']): ?><div id="highlighted"><?php print render($page['highlighted']); ?></div><?php endif; ?>
    <?php print render($title_prefix); ?>

    <?php print render($title_suffix); ?>
	<?php global $user; $node = node_load(arg(1));?>
	<?php if($node->uid == $user->uid || $user->uid == 1) :?>
    <?php if (!empty($tabs['#primary'])): ?><div class="tabs-wrapper clearfix"><?php print render($tabs); ?></div><?php endif; ?>
	<?php endif;?>
    <?php print render($page['help']); ?>
    <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
    <?php print render($page['content']); ?>
	</div>
  </section> <!-- /#main -->
  <?php if ($page['sidebar_first']): ?>
    <aside id="sidebar-first" role="complementary" class="sidebar clearfix">
      <?php print render($page['sidebar_first']); ?>
    </aside>  <!-- /#sidebar-first -->
  <?php endif; ?>
  <?php if ($page['sidebar_second']): ?>
    <aside id="sidebar-second" role="complementary" class="sidebar clearfix">
      <?php print render($page['sidebar_second']); ?>
    </aside>  <!-- /#sidebar-second -->
  <?php endif; ?>
  <footer id="footer" role="contentinfo" class="clearfix">
    <?php print render($page['footer']) ?>
    <?php print $feed_icons ?>
  </footer> <!-- /#footer -->
</div> <!-- /#container -->
<?php
$node = node_load(arg(1));
?>