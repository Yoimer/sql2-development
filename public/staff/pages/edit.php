<?php
require_once('../../../private/initialize.php');

require_login();

if(!isset($_GET['id'])) {
  redirect_to(url_for('/staff/pages/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {
 
  // Handle form values sent by new.php

  $page = [];
  $page['id'] = $id;
  $page['subject_id'] = isset($_POST['visible']) ? $_POST['subject_id'] : 'DEFAULT VALUE';
  $page['menu_name'] = isset($_POST['menu_name']) ? $_POST['menu_name'] : 'DEFAULT VALUE';
  $page['position'] = isset($_POST['position']) ? $_POST['position'] : 'DEFAULT VALUE';
  $page['visible'] = isset($_POST['visible']) ? $_POST['visible'] : 'DEFAULT VALUE';
  $page['content'] = isset($_POST['visible']) ? $_POST['content'] : 'DEFAULT VALUE';

  $result = update_page($page);
  if($result === true) {
    $_SESSION['message'] = 'The page' . ' - ' . $page['menu_name'] . ' - '. 'was updated successfully.';
    redirect_to(url_for('/staff/pages/show.php?id=' . $id));
  } else {
    $errors = $result;
  }

} else {

  $page = find_page_by_id($id);

}

$page_set = find_all_pages();
$page_count = mysqli_num_rows($page_set);
mysqli_free_result($page_set);

?>

<?php $page_title = 'Edit Page'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/subjects/show.php?id=' . h(u($page['subject_id']))); ?>">&laquo; Back to Subject Page</a>

  <div class="page edit">
    <h1>Edit Page</h1>

    <?php echo display_errors($errors); ?>

    <form action="<?php echo url_for('/staff/pages/edit.php?id=' . h(u($id))); ?>" method="post">
      <dl>
        <dt>Subject</dt>
        <dd>
          <select name="subject_id">
          <?php
            $subject_set = find_all_subjects();
            while($subject = mysqli_fetch_assoc($subject_set)) {
              echo "<option value=\"" . h($subject['id']) . "\"";
              if($page["subject_id"] == $subject['id']) {
                echo " selected";
              }
              echo ">" . h($subject['menu_name']) . "</option>";
            }
            mysqli_free_result($subject_set);
          ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Menu Name</dt>
        <dd><input type="text" name="menu_name" value="<?php echo h($page['menu_name']); ?>" /></dd>
      </dl>
      <dl>
        <dt>Position</dt>
        <dd>
          <select name="position">
            <?php
              for($i=1; $i <= $page_count; $i++) {
                echo "<option value=\"{$i}\"";
                if($page["position"] == $i) {
                  echo " selected";
                }
                echo ">{$i}</option>";
              }
            ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Visible</dt>
        <dd>
          <input type="hidden" name="visible" value="0" />
          <input type="checkbox" name="visible" value="1"<?php if($page['subject_id'] == "1") { echo " checked"; } ?> />
        </dd>
      </dl>
      <dl>
        <dt>Content</dt>
        <dd>
          <textarea name="content" cols="60" rows="10"><?php echo h($page['content']); ?></textarea>
        </dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Edit Page" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
