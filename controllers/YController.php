<?php
namespace app\controllers;

use app\extensions\action\Functions;
use app\extensions\action\GoogleYT;
use app\models\Users;
use app\models\Videos;
use lithium\storage\Session;
use Google_Service_YouTube;
use Google_Service_YouTube_VideoSnippet;
use Google_Service_YouTube_VideoStatus;
use Google_Service_YouTube_Video;
use Google_Client;

class YController extends \lithium\action\Controller {

	 protected function _init() {
  parent::_init();
  $this->_render['layout'] = 'default';
 }

	public function upload(){
	
		$oauthClientID     = GOOGLE_PROJECT_CLIENT_ID;
		$oauthClientSecret = GOOGLE_PROJECT_CLIENT_SECRET;
		$baseURL           = 'https://wecapacitate.com/y/';
		$redirectURL       = $baseURL.'upload';

		define('OAUTH_CLIENT_ID',$oauthClientID);
		define('OAUTH_CLIENT_SECRET',$oauthClientSecret);
		define('REDIRECT_URL',$redirectURL);
		define('BASE_URL',$baseURL);

		if(!session_id()) session_start();

		$client = new Google_Client();
		$client->setClientId(OAUTH_CLIENT_ID);
		$client->setClientSecret(OAUTH_CLIENT_SECRET);
		$client->setScopes('https://www.googleapis.com/auth/youtube');
		$client->setRedirectUri(REDIRECT_URL);
		
		if($this->request->data){
				
	   // Video info
    $title = $this->request->data['title'];
    $desc = $this->request->data['description'];
    $tags = $this->request->data['tags'];
    $privacy = !empty($this->request->data['privacy'])?$this->request->data['privacy']:'unlisted';
    
    // Check whether file field is not empty
    if($this->request->data["file"]["name"] != ''){
        // File upload path
        $fileName = str_shuffle('codexworld').'-'.basename($this->request->data["file"]["name"]);
        $filePath = "videos/".$fileName;

        // Check the file type
        $allowedTypeArr = array("video/mp4", "video/avi", "video/mpeg", "video/mpg", "video/mov", "video/wmv", "video/rm");
        if(in_array($this->request->data['file']['type'], $allowedTypeArr)){
            // Upload file to local server
            if(move_uploaded_file($_FILES['file']['tmp_name'], $filePath)){
                // Insert video data in the database
                $vdata = array(
                    'title' => $title,
                    'description' => $desc,
                    'tags' => $tags,
                    'privacy' => $privacy,
                    'file_name' => $fileName
                );
                $insert = Videos::create();
																$insert->save($vdata);
                // Store db row id in the session
																Session::write('uploadedFileId',$insert);
            }else{
                header("Location:".BASE_URL."upload?err=ue");
                exit;
            }
        }else{
            header("Location:".BASE_URL."upload?err=fe");
            exit;
        }
    }else{
        header('Location:'.BASE_URL.'upload?err=bf');
        exit;
    }

				$videoData = Videos::find('first',array(
					'conditions' => array('_id'=>(string)$insert)
				));
		}		// 			

	$tokenSessionKey = 'token-' . $client->getAccessToken();
	if (isset($_GET['code'])) {
  if (strval($_SESSION['state']) !== strval($_GET['state'])) {
    die('The session state did not match.');
  }

  $client->authenticate($_GET['code']);
		
  $_SESSION[$tokenSessionKey] = $client->getAccessToken();
		
  header('Location: ' . REDIRECT_URL);
}

if (isset($_SESSION[$tokenSessionKey])) {
  $client->setAccessToken($_SESSION[$tokenSessionKey]);
}

// Check to ensure that the access token was successfully acquired.
	if ($client->getAccessToken()) {
  $htmlBody = '';
  try{
    // REPLACE this value with the path to the file you are uploading.
				$videoData = Videos::find('first',array(
					'order' => array('_id'=>'ASC')
				));
    $videoPath = 'videos/'.$videoData['file_name'];
    
    if(!empty($videoData['youtube_video_id'])){
        // Uploaded video data
        $videoTitle = $videoData['title'];
        $videoDesc = $videoData['description'];
        $videoTags = $videoData['tags'];
        $videoId = $videoData['youtube_video_id'];
    }else{
        // Create a snippet with title, description, tags and category ID
        // Create an asset resource and set its snippet metadata and type.
        // This example sets the video's title, description, keyword tags, and
        // video category.

        $snippet = new Google_Service_YouTube_VideoSnippet();
        $snippet->setTitle($videoData['title']);
        $snippet->setDescription($videoData['description']);
        $snippet->setTags(explode(",", $videoData['tags']));
    
        // Numeric video category. See
        // https://developers.google.com/youtube/v3/docs/videoCategories/list
        $snippet->setCategoryId("22");
    
        // Set the video's status to "public". Valid statuses are "public",
        // "private" and "unlisted".
        $status = new Google_Service_YouTube_VideoStatus();
        $status->privacyStatus = $videoData['privacy'];
    
        // Associate the snippet and status objects with a new video resource.
        $video = new Google_Service_YouTube_Video();
        $video->setSnippet($snippet);
        $video->setStatus($status);
    
        // Specify the size of each chunk of data, in bytes. Set a higher value for
        // reliable connection as fewer chunks lead to faster uploads. Set a lower
        // value for better recovery on less reliable connections.
        $chunkSizeBytes = 1 * 1024 * 1024;
    
        // Setting the defer flag to true tells the client to return a request which can be called
        // with ->execute(); instead of making the API call immediately.
        $client->setDefer(true);
    
        // Create a request for the API's videos.insert method to create and upload the video.
        $insertRequest = $youtube->videos->insert("status,snippet", $video);
    
        // Create a MediaFileUpload object for resumable uploads.
        $media = new Google_Http_MediaFileUpload(
            $client,
            $insertRequest,
            'video/*',
            null,
            true,
            $chunkSizeBytes
        );
        $media->setFileSize(filesize($videoPath));
    
    
        // Read the media file and upload it chunk by chunk.
        $status = false;
        $handle = fopen($videoPath, "rb");
        while (!$status && !feof($handle)) {
          $chunk = fread($handle, $chunkSizeBytes);
          $status = $media->nextChunk($chunk);
        }
        fclose($handle);
    
        // If you want to make other calls after the file upload, set setDefer back to false
        $client->setDefer(false);
        
        // Update youtube video id to database
        $db->update($videoData['id'], $status['id']);
        
        // Delete video file from local server
        @unlink("videos/".$videoData['file_name']);
        
        // uploaded video data
        $videoTitle = $status['snippet']['title'];
        $videoDesc = $status['snippet']['description'];
        $videoTags = implode(",",$status['snippet']['tags']);
        $videoId = $status['id'];
    }
    
    // uploaded video embed html
    $htmlBody .= "<p class='succ-msg'>Video Uploaded to YouTube</p>";
    $htmlBody .= '<embed width="400" height="315" src="https://www.youtube.com/embed/'.$videoId.'"></embed>';
    $htmlBody .= '<ul><li><b>Title: </b>'.$videoTitle.'</li>';
    $htmlBody .= '<li><b>Description: </b>'.$videoDesc.'</li>';
    $htmlBody .= '<li><b>Tags: </b>'.$videoTags.'</li></ul>';
    $htmlBody .= '<a href="logout.php">Logout</a>';

  } catch (Google_Service_Exception $e) {
    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
  } catch (Google_Exception $e) {
    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
    $htmlBody .= 'Please reset session <a href="logout.php">Logout</a>';
  }

  $_SESSION[$tokenSessionKey] = $client->getAccessToken();
} elseif (OAUTH_CLIENT_ID == '') {
  $htmlBody = <<<END
  <h3>Client Credentials Required</h3>
  <p>
    You need to set <code>\$oauthClientID</code> and
    <code>\$oauthClientSecret</code> before proceeding.
  <p>
END;
} else {
  // If the user hasn't authorized the app, initiate the OAuth flow
  $state = mt_rand();
		print_r($state);
  $client->setState($state);
  $_SESSION['state'] = $state;
  $authUrl = $client->createAuthUrl();
  return $this->redirect($authUrl);

			}
		}
	//}
}
?>