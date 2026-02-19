<?php
if ( ! defined('ABSPATH') ) exit;

/**
 * Metabox for fkhri_portfolio
 * Fields:
 * - Name, Age, Area, Method, Grafts, Video URL (optional), Avatar image (optional)
 */

// Meta keys (keep consistent for widgets/shortcodes)
const FKHRI_PM_NAME   = 'fkhri_name';
const FKHRI_PM_AGE    = 'fkhri_age';
const FKHRI_PM_AREA   = 'fkhri_area';
const FKHRI_PM_METHOD = 'fkhri_method';
const FKHRI_PM_GRAFTS = 'fkhri_grafts';
const FKHRI_PM_VIDEO  = 'fkhri_video_url';
const FKHRI_PM_AVATAR = 'fkhri_avatar_id';

add_action('add_meta_boxes', function () {
  add_meta_box(
    'fkhri_portfolio_meta',
    'نمونه کار ها',
    'fkhri_portfolio_meta_box_cb',
    'fkhri_portfolio',
    'normal',
    'high'
  );
});

function fkhri_portfolio_meta_box_cb($post){
  wp_nonce_field('fkhri_portfolio_save', 'fkhri_portfolio_nonce');

  $val = function($key) use ($post){
    return get_post_meta($post->ID, $key, true);
  };

  $name   = $val(FKHRI_PM_NAME);
  $age    = $val(FKHRI_PM_AGE);
  $area   = $val(FKHRI_PM_AREA);
  $method = $val(FKHRI_PM_METHOD);
  $grafts = $val(FKHRI_PM_GRAFTS);
  $video  = $val(FKHRI_PM_VIDEO);
  $avatar = (int) $val(FKHRI_PM_AVATAR);

  ?>
  <style>
    .fkhri-field{margin:12px 0}
    .fkhri-field label{display:block;font-weight:700;margin-bottom:6px}
    .fkhri-row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
    .fkhri-help{color:#666;font-size:12px;margin-top:6px}
    .fkhri-avatar-wrap{display:flex;align-items:center;gap:12px;margin-top:8px}
    .fkhri-avatar-img{width:64px;height:64px;border-radius:12px;object-fit:cover;background:#eee}
    .fkhri-btn{display:inline-block;padding:6px 10px;border:1px solid #ccd0d4;border-radius:6px;background:#fff;cursor:pointer}
  </style>

  <div class="fkhri-row">
    <div class="fkhri-field">
      <label>Name</label>
      <input type="text" name="<?php echo esc_attr(FKHRI_PM_NAME); ?>" value="<?php echo esc_attr($name); ?>" class="widefat">
    </div>
    <div class="fkhri-field">
      <label>Age</label>
      <input type="number" min="1" name="<?php echo esc_attr(FKHRI_PM_AGE); ?>" value="<?php echo esc_attr($age); ?>" class="widefat">
    </div>
  </div>

  <div class="fkhri-row">
    <div class="fkhri-field">
      <label>Transplant Area</label>
      <input type="text" name="<?php echo esc_attr(FKHRI_PM_AREA); ?>" value="<?php echo esc_attr($area); ?>" class="widefat">
    </div>
    <div class="fkhri-field">
      <label>Method</label>
      <input type="text" name="<?php echo esc_attr(FKHRI_PM_METHOD); ?>" value="<?php echo esc_attr($method); ?>" class="widefat">
    </div>
  </div>

  <div class="fkhri-row">
    <div class="fkhri-field">
      <label>Grafts Count</label>
      <input type="text" name="<?php echo esc_attr(FKHRI_PM_GRAFTS); ?>" value="<?php echo esc_attr($grafts); ?>" class="widefat">
    </div>
    <div class="fkhri-field">
      <label>Video URL (optional)</label>
      <input type="url" name="<?php echo esc_attr(FKHRI_PM_VIDEO); ?>" value="<?php echo esc_url($video); ?>" class="widefat" placeholder="https://...">
      <div class="fkhri-help">YouTube / Vimeo / MP4 URL</div>
    </div>
  </div>

  <div class="fkhri-field">
    <label>Avatar Image (optional)</label>
    <input type="hidden" id="fkhri_avatar_id" name="<?php echo esc_attr(FKHRI_PM_AVATAR); ?>" value="<?php echo esc_attr($avatar); ?>">
    <div class="fkhri-avatar-wrap">
      <?php if ($avatar): ?>
        <?php echo wp_get_attachment_image($avatar, 'thumbnail', false, ['class'=>'fkhri-avatar-img']); ?>
      <?php else: ?>
        <div class="fkhri-avatar-img"></div>
      <?php endif; ?>
      <button type="button" class="fkhri-btn" id="fkhri_avatar_pick">Select</button>
      <button type="button" class="fkhri-btn" id="fkhri_avatar_remove">Remove</button>
    </div>
  </div>

  <script>
  (function(){
    if (!window.wp || !wp.media) return;
    var frame;
    var pick = document.getElementById('fkhri_avatar_pick');
    var remove = document.getElementById('fkhri_avatar_remove');
    var input = document.getElementById('fkhri_avatar_id');

    function setPreview(id, url){
      var wrap = pick.closest('.fkhri-avatar-wrap');
      var img = wrap.querySelector('img.fkhri-avatar-img');
      var ph = wrap.querySelector('div.fkhri-avatar-img');
      if (img) img.remove();
      if (!ph){ ph = document.createElement('div'); ph.className='fkhri-avatar-img'; wrap.insertBefore(ph, wrap.firstChild); }
      if (url){
        var n = document.createElement('img');
        n.className = 'fkhri-avatar-img';
        n.src = url;
        ph.replaceWith(n);
      } else {
        ph.style.background = '#eee';
      }
      input.value = id || '';
    }

    pick.addEventListener('click', function(e){
      e.preventDefault();
      if (frame) { frame.open(); return; }
      frame = wp.media({ title: 'Select Avatar', button: { text: 'Use this image' }, multiple: false });
      frame.on('select', function(){
        var att = frame.state().get('selection').first().toJSON();
        setPreview(att.id, att.sizes && att.sizes.thumbnail ? att.sizes.thumbnail.url : att.url);
      });
      frame.open();
    });

    remove.addEventListener('click', function(e){
      e.preventDefault();
      setPreview('', '');
    });
  })();
  </script>
  <?php
}

add_action('save_post_fkhri_portfolio', function($post_id){

  // Basic checks
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if ( ! isset($_POST['fkhri_portfolio_nonce']) || ! wp_verify_nonce($_POST['fkhri_portfolio_nonce'], 'fkhri_portfolio_save') ) return;
  if ( ! current_user_can('edit_post', $post_id) ) return;

  $map = [
    FKHRI_PM_NAME   => 'sanitize_text_field',
    FKHRI_PM_AGE    => function($v){ return (string) max(0, (int)$v); },
    FKHRI_PM_AREA   => 'sanitize_text_field',
    FKHRI_PM_METHOD => 'sanitize_text_field',
    FKHRI_PM_GRAFTS => 'sanitize_text_field',
    FKHRI_PM_VIDEO  => 'esc_url_raw',
  ];

  foreach ($map as $key => $sanitize){
    $val = $_POST[$key] ?? '';
    $val = is_callable($sanitize) ? call_user_func($sanitize, $val) : $val;
    if ($val === '' || $val === '0') delete_post_meta($post_id, $key);
    else update_post_meta($post_id, $key, $val);
  }

  $avatar = isset($_POST[FKHRI_PM_AVATAR]) ? (int) $_POST[FKHRI_PM_AVATAR] : 0;
  if ($avatar > 0) update_post_meta($post_id, FKHRI_PM_AVATAR, $avatar);
  else delete_post_meta($post_id, FKHRI_PM_AVATAR);

});
