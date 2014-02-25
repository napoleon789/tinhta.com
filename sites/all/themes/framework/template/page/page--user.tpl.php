<div id="container" class="clearfix <?php if($user -> uid <= 0) echo 'no_login';?>">
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable" ><?php print t('Skip to main content'); ?></a>
  </div>
    <?php if($user->uid > 0 ) :  ?>
  <header id="header" role="banner" class="clearfix">
    <div id ="pane-node-random">
      <div class="user">
        <div class="user_back">
          <div class="left">
            <?php
            print l("Giới thiệu","gioi-thieu-tinhtacom.html");
            echo '  |  ';
            print l("Góp ý","node/add/gop-y");
            echo '  |  ';
            print l(" Gửi bài","node/add/article");
            ?>
          </div>
          <div class= "right_us">

            <?php
            global $user;
            if($user->uid >0) {
              $block = module_invoke('privatemsg', 'block_view', 'privatemsg-new');
              print render($block['content']);
              print l($user->name,'user/'.$user->uid);
              echo ' | ';

              print l('Logout','user/logout');
            }
            else
            {

              print l('Đăng nhập','user');
              echo ' | ';
              print l('Đăng ký','user/register');
            }


            ?>
          </div>
        </div>
      </div>
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
          <h1 id="site-name">
            <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>"><span><?php print $site_name; ?></span></a>
          </h1>
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

    </div>
    <?php print render($page['header']); ?>
</div>
  </header> <!-- /#header -->
  <section id="main" role="main" class="clearfix main_user">

    <?php print $messages; ?>
    <a id="main-content"></a>
    <?php if ($page['highlighted']): ?><div id="highlighted"><?php print render($page['highlighted']); ?></div><?php endif; ?>
    <?php print render($title_prefix); ?>

    <?php print render($title_suffix); ?>
	<?php global $user;
	$arg = arg();
	?>
            <div class="padding_chua">
    <?php if (!empty($tabs['#primary'])): ?><div class="tabs-wrapper clearfix"><?php print render($tabs); ?></div><?php endif; ?>


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
    <?php endif;?>
     <?php if($user->uid<=0) : ?>

<div class="bor_user">
    <div class="padding_user">
        <div class="header_user">
        <div class="khauhieu">Tình yêu có  trong bạn không?</div>
        <div class="tinhta"><a href ="http://tinhta.com/">tinhta.com</a></div>
        <?php if (!empty($tabs['#primary'])): ?><div class="tabs-wrapper clearfix"><?php print render($tabs); ?></div><?php endif; ?>
       </div>
        <?php print render($page['help']); ?>
        <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links); ?></ul><?php endif; ?>
        <?php print render($page['content']); ?>
        </div>
</div>
    <?php endif; ?>
</div> <!-- /#container -->


