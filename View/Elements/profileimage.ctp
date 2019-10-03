<?php
$thumbName = $user['Profileimage']['profile'];
$thumbPath = $user['Profileimage']['dir'];
$base_ = "../files/profileimage/profile/";
if ($thumbName !== null) {
  echo $this->html->image($base_ . $thumbPath . DS . 'profile150_' . $thumbName, array('class' => ' rounded-lg profileImage'));
} else {
  echo $this->html->image("profile_noimage.jpg", array('class' => ' rounded-lg profileImage'));
}
