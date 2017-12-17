<?php
/*
copyright @ medantechno.com
Modified @ Farzain - zFz
2017

*/

require_once('./line_class.php');
require_once('./unirest-php-master/src/Unirest.php');

$channelAccessToken = 'ja+ZPnJrUAg71qE+CBIlao+rDQEpvpFZjoOTjNp74bSZAQDGDRLccobEDI5ZwDPT1MSHLwuiKr/mJPTTNGNh0bry4S0VP4aHthoaQmuD6jJdIusJkx4OjGmYsl58Gw69NhKCpvIVI6bil/vpXxwSlgdB04t89/1O/w1cDnyilFU='; //sesuaikan 
$channelSecret = 'e7e368bc820318a3cfd1c9f03fa468cd';//sesuaikan

$client = new LINEBotTiny($channelAccessToken, $channelSecret);

$userId 	= $client->parseEvents()[0]['source']['userId'];
$groupId 	= $client->parseEvents()[0]['source']['groupId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$timestamp	= $client->parseEvents()[0]['timestamp'];
$type 		= $client->parseEvents()[0]['type'];

$message 	= $client->parseEvents()[0]['message'];
$messageid 	= $client->parseEvents()[0]['message']['id'];

$profil = $client->profil($userId);

$pesan_datang = explode(" ", $message['text']);

$command = $pesan_datang[0];
$options = $pesan_datang[1];
if (count($pesan_datang) > 2) {
    for ($i = 2; $i < count($pesan_datang); $i++) {
        $options .= '+';
        $options .= $pesan_datang[$i];
    }
}

#-------------------------[Function]-------------------------#
function shalat($keyword) {
    $uri = "https://time.siswadi.com/pray/" . $keyword;

    $response = Unirest\Request::get("$uri");

    $json = json_decode($response->raw_body, true);
    $result = "Jadwal Shalat Daerah ";
	$result .= $json['location']['address'];
	$result .= "\nTanggal : ";
	$result .= $json['time']['date'];
	$result .= "\n\nShubuh : ";
	$result .= $json['data']['Fajr'];
	$result .= "\nDzuhur : ";
	$result .= $json['data']['Dhuhr'];
	$result .= "\nAshar : ";
	$result .= $json['data']['Asr'];
	$result .= "\nMaghrib : ";
	$result .= $json['data']['Maghrib'];
	$result .= "\nIsya : ";
	$result .= $json['data']['Isha'];
    return $result;
}
#-------------------------[Function]-------------------------#

# require_once('./src/function/search-1.php');
# require_once('./src/function/download.php');
# require_once('./src/function/random.php');
# require_once('./src/function/search-2.php');
# require_once('./src/function/hard.php');

//show menu, saat join dan command /menu
if ($type == 'join' || $command == '/menu') {
    $text = "Thx for invite, ketk /kelar untuk mengeluarkan Mpuy";
    $balas = array(
        'replyToken' => $replyToken,
        'messages' => array(
            array(
                'type' => 'text',
                'text' => $text
            )
        )
    );
}

//pesan bergambar
if($message['type']=='text') {
	    if ($command == '/jshalat') {

        $result = shalat($options);
        $balas = array(
            'replyToken' => $replyToken,
            'messages' => array(
                array(
                    'type' => 'text',
                    'text' => $result
                )
            )
        );
    }
	else
	if($pesan_datang=='1') {
		
		
		$balas = array(
							'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Halo '.$profil->displayName.', Kamu memilih menu 1,'
									)
							)
						);
				
	}
	else
#	if($pesan_datang=='2')
#	{
#		$get_sub = array();
#		$aa =   array(
#						'type' => 'image',									
#						'originalContentUrl' => 'https://medantechno.com/line/images/bolt/1000.jpg',
#						'previewImageUrl' => 'https://medantechno.com/line/images/bolt/240.jpg'	
#						
#					);
#		array_push($get_sub,$aa);	

		$get_sub[] = array(
									'type' => 'text',									
									'text' => 'Halo '.$profil->displayName.', Kamu memilih menu 2, harusnya gambar muncul.'
								);
		
		$balas = array(
					'replyToken' 	=> $replyToken,														
					'messages' 		=> $get_sub
				 );	
	}
	else
#	if($pesan_datang=='3')
#	{
#		
#		$balas = array(
#							'replyToken' => $replyToken,														
#							'messages' => array(
#								array(
#										'type' => 'text',					
#										'text' => 'Fungsi PHP base64_encode medantechno.com :'. base64_encode("medantechno.com")
#									)
#							)
#						);
#				
#	}
	else
	if($pesan_datang=='4')
	{
		
		$balas = array(
							'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Jam Server Mpuy : '. date('Y-m-d H:i:s')
									)
							)
						);
				
	}
	else
	if($pesan_datang=='6')
	{
		
		$balas = array(
							'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'location',					
										'title' => 'Lokasi Mpuy.. Klik Detail',					
										'address' => 'Bogor',					
									)
							)
						);
				
	}
	else
	if($pesan_datang=='7')
	{
		
		$balas = array(
							'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Testing PUSH pesan ke anda'
									)
							)
						);
						
		$push = array(
							'to' => $userId,									
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Pesan ini dari Puy'
									)
							)
						);
						
		
		$client->pushMessage($push);
				
	}

	else{

#		$balas = array(
#							'replyToken' => $replyToken,														
#							'messages' => array(
#								array(
#										'type' => 'text',					
#										'text' => 'Halo.. Selamat datang di medantechno.com .        Untuk testing menu pilih 1,2,3,4,5 ... atau stiker'
#									)
#							)
#						);
#						
#	}
#
}else if($message['type']=='sticker')
{	
	$balas = array(
							'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',									
										'text' => 'wih tikel baru ya '										
									
									)
							)
						);
						
}
if (isset($balas)) {
    $result = json_encode($balas);
//$result = ob_get_clean();

    file_put_contents('./balasan.json', $result);


    $client->replyMessage($balas);
}
?>
