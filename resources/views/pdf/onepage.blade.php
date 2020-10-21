<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<link rel="shortcut icon" href="{{ asset('admin/images/favicon.png') }}" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ env('APP_NAME') }}</title>
    <style type="text/css">
        .page-break {page-break-after: always;}
        .topictag {color: #168CC7;}
        .keyphrase {color: #FF512B;}
        .keyword {color: #ED1E68;}
        .arp a {color: #17AA87;}
        .incorrect a {color: #FF0000;}
        .correct a {color: #33662F;}
        .not-ie a {-webkit-transition: background-color .2s ease, border .2s ease, color .2s ease, opacity .2s ease-in-out;transition: background-color .2s ease, border .2s ease, color .2s ease, opacity .2s ease-in-out;}
        a {text-decoration: none;}
        header {position: fixed;top: 0px;left: 0px;right: 0px;}
        footer {position: fixed;bottom: -30px;left: 0px;right: 0px;height: 50px;}
        .main_detiles{position: relative;top: 60px;}
	
		
		* {
font-family: Firefly Sung, DejaVu Sans, sans-serif;
}
    </style>
    <?php
        $currentTopic = [];
        if(!empty($booking->topics)){
            foreach ($booking->topics as $ckey => $ctopic) {
                $currentTopic[] = $ctopic->title;
            }
        }
        $previousTopic = [];
        if(!empty($previousBooking->topics)){
            foreach ($previousBooking->topics as $tkey => $topic) {
                $previousTopic[] = $topic->title;
            }
        }
    ?>
</head>
<body>
    <header>
        <img src="{{ asset('images/logo_accent.png') }}">
        <hr>
    </header>

    <footer>
        <hr>
    </footer>

    <main class="main_detiles" style="">
        
        <table cellpadding="10" cellspacing="0" style="width: 100%;border-collapse: collapse;">
			<tr>
				<td style="width: 100%; line-height: 16px; font-size: 18px; text-align:center;">
					{{ isset($currBookingIndx) ? $currBookingIndx : ''}} {{ ucfirst($booking['student']['firstname']) }} {{ ucfirst($booking['student']['lastname']) }} | Lokalingo OnePage {{ $booking['onepage_title'] }}
				</td>
			</tr>
		</table>
		
		<table cellspacing="0" cellpadding="10" class="recall-table">
			<tr><td height="10"></td></tr>
			<tr>
				<td style="font-size:16px; font-weight:normal;">
					<?php echo $booking->canvas_html ?>
				</td>
			</tr>
		</table>
		
		<table cellspacing="0" cellpadding="10" class="recall-table" style="width:100%;">
			<tr><td colspan="2" height="20"></td></tr>
			<tr>
				<td colspan="2" style="border: 1px solid #ccc;background-color:#0a5996;color:#fff;font-size:15px;line-height: 16px;text-align: center;">Lesson Topics・レッスンの話題</td>
			</tr>
			<tr>
				<td width="20%" style="border: 1px solid #ccc;color:#333;background-color: #eee;font-size: 14px;line-height:16px;">Previous・前回</td>
				<td width="80%" style="border: 1px solid #ccc;color:#333;background-color: #eee;font-size: 14px;line-height:16px;">
					{{ !empty($previousTopic) ? implode(',', $previousTopic) : '' }}
				</td>
			</tr>
			<tr>
				<td width="20%" style="border: 1px solid #ccc;color:#333;background-color: #eee;font-size: 14px;line-height: 16px;">Current・今回</td>
				<td width="80%" style="border: 1px solid #ccc;color:#333;background-color: #eee;font-size: 14px;line-height: 16px;">
					{{ !empty($currentTopic) ? implode(',', $currentTopic) : '' }}
				</td>
			</tr>
		</table>
		
		<table cellspacing="0" cellpadding="10" class="recall-table" style="width:100%;" >
			<tr><td colspan="2" height="25"></td></tr>
			<tr style="background-color: #02a1da;color:#fff;">
				<td width="80%" style="font-size:15px;line-height: 16px;border: 1px solid #ccc;">Active Recall Pair・アクティブリコールペアの復習</td>
				<td width="20%" style="font-size:15px;line-height: 16px;border: 1px solid #ccc;">Status</td>
			</tr>
			@if(!empty($studentLesson->arps))
				@foreach ($studentLesson->arps as $arp)
					<?php
					if($arp->is_new == 1) {
						$bgcolor = 'background-color: #e8e8e8;';
					} else {
						$bgcolor = '';
					}
					?>
					<tr style="color: #777; {{ $bgcolor }}">
						<td width="80%" style="font-size:15px;line-height: 16px; border: 1px solid #ccc;">
							<a style="color: #000000; font-size: 14px;text-decoration: none;" href="https://translate.google.com/#en/ja/urlencode({{ $arp->line_1 }} {{ $arp->line_2 }})">{{ $arp->line_1 }}<br>{{ $arp->line_2 }}</a>
						</td>
						<td width="20%" align="center" valign="middle" style="font-size:16px;line-height: 16px;border: 1px solid #ccc;">
							@switch($arp->status)
								@case(1)
									<img src="{{ asset('images/img_1.png') }}">
									@break
								@case(2)
									<img src="{{ asset('images/img_2.png') }}">
									@break
								@case(3)
									<img src="{{ asset('images/img_3.png') }}">
									@break
								@case(4)
									<img src="{{ asset('images/img_4.png') }}">
									@break
								@case(5)
									<img src="{{ asset('images/img_5.png') }}">
									@break
							@endswitch
						</td>
					</tr>			
				@endforeach
			@endif
        </table>	


        <table style="width: 100%;" table cellspacing="0" cellpadding="10">
				<tr><td colspan="2" height="25"></td></tr>
                <tr style="background-color: #02a1da;color:#fff;">
                    <td width="80%" style="font-size:15px;line-height: 16px;border: 1px solid #ccc;">Key words and phrases.キーワードとフレーズの復習</td>
                    <td width="20%" style="font-size:15px;line-height: 16px;border: 1px solid #ccc;">Status</td>
                </tr>
            <tbody>
			@if(!empty($studentLesson->keywords))
                @foreach ($studentLesson->keywords as $keyword)
					<?php
					if($keyword->is_new == 1) {
						$bgcolor = 'background-color: #e8e8e8;';
					} else {
						$bgcolor = '';
					}
					?>
                <tr style="{{ $bgcolor }} width: 100%;text-align: center;">
                    <td style="width: 80%; font-size: 14px; text-align: left; border: 1px solid #ccc;">
                        {{ $keyword->keyword }}
                    </td>
                    <td style="width: 20%; font-size: 16px;border: 1px solid #ccc;" align="center" valign="middle">
                        @switch($keyword->status)
                            @case(1)
                                <img src="{{ asset('images/img_1.png') }}">
                                @break
                            @case(2)
                                <img src="{{ asset('images/img_2.png') }}">
                                @break
                            @case(3)
                                <img src="{{ asset('images/img_3.png') }}">
                                @break
                            @case(4)
                                <img src="{{ asset('images/img_4.png') }}">
                                @break
                            @case(5)
                                <img src="{{ asset('images/img_5.png') }}">
                                @break
                        @endswitch
                    </td>
                </tr>
                @endforeach
			@endif	
            </tbody>
        </table>
		

        <table cellpadding="10" cellspacing="0" style="width: 100%;border-collapse: collapse;">
            <tbody>
				<tr><td colspan="2" height="25"></td></tr>
                <tr style="background-color: #efefef;color: #777;">
                    <td style="padding: 10px;width: 50%;text-align: left;border: 1px solid #ccc;">Incorrect Phrases.間違えたフレーズ</td>
                    <td style="padding: 10px;width: 50%;text-align: left;border: 1px solid #ccc;">Corrected Phrases.正しいフレーズ</td>
                </tr>
				@if(!empty($studentLesson->cips))
					@foreach ($studentLesson->cips as $cip)
					<tr style="padding: 2px 4px;">
						<td style="padding: 10px;width: 50%;text-align: left;font-size: 14px;background-color: #e8e8e8;border: 1px solid #ccc;">{{$cip->incorrect_phrase}}</td>
						<td style="padding: 10px;width: 50%;text-align: left;font-size: 14px;background-color: #e8e8e8;border: 1px solid #ccc;">{{$cip->correct_phrase}}</td>
					</tr>
					@endforeach
				@endif		

            </tbody>
        </table>


        <table cellpadding="10" cellspacing="0" style="width: 100%;border-collapse: collapse;">
			<tr><td height="25"></td></tr>
			<tr style="background-color: #e26563; color: #f5f5f5;">
				<td style="border: 1px solid #ccc;text-align:center;">Points to Improve・のばせるポイント</td>
			</tr>
			<tr style="background-color: #efefef;color: #777;">
				<td style="width: 100%;word-wrap: break-word;line-height: 18px;border: 1px solid #ccc;font-size: 14px;">
					@if(!empty($booking->points_to_improve_comment))
						{!! nl2br($booking->points_to_improve_comment) !!}
					@endif
				</td>
			</tr>
		</table>
		
		<table cellpadding="10" cellspacing="0" style="width: 100%;border-collapse: collapse;">
			<tr><td height="25"></td></tr>
			<tr style="background-color: #92c57a; color: #f5f5f5;">
				<td style="border: 1px solid #ccc;	font-size: 15px;line-height: 16px;text-align: center;">Strong Points・良いポイント</td>
			</tr>
			<tr style="background-color: #efefef;color: #777;">
				<td style="line-height: 18px;border: 1px solid #ccc;font-size: 14px;">
					@if(!empty($booking->strong_points_comment))
						{!! nl2br($booking->strong_points_comment) !!}
					@endif
				</td>
			</tr>
		</table>
		
		<table cellpadding="10" cellspacing="0" style="width: 100%;border-collapse: collapse;">
			<tr><td height="25"></td></tr>
			<tr style="background-color: #6c9cee; color: #f5f5f5;">
				<td style="border: 1px solid #ccc;	font-size: 15px;line-height: 16px;text-align: center;">Lesson Comment・レッスンについてのコメント</td>
			</tr>
			<tr style="background-color: #efefef;color: #777;">
			<td style="line-height: 18px;border: 1px solid #ccc;font-size: 14px;">
					@if(!empty($booking->booking_comments))
						{!! nl2br($booking->booking_comments) !!}
					@endif
				</td>
			</tr>
		</table>
		
		
		
        <?php $tasks = !empty($studentLesson->tasks) ? $studentLesson->tasks->toArray() : []; ?>
        <table cellpadding="10" cellspacing="0" style="width: 100%; page-break-before:always;">
			<tr><td colspan="2" height="25"></td></tr>
			<tr style="background-color:#c9daf8;color:#222;">
				<td style="width: 50%;font-size:15px;line-height:16px;border:1px solid #ccc;">Lesson Materials and Tasks・教材</td>
				<td style="width: 50%;font-size:15px;line-height:16px;border:1px solid #ccc;">Lesson Tasks・課題</td>
			</tr>
            <tr>
                <td style="width: 50%;text-align: left;color: #000;border:1px solid #ccc;word-wrap: break-word;font-size: 14px;" valign="top">
                    @if (!empty($tasks['lessons_material_and_tasks_1']))
                        <?php echo nl2br($tasks['lessons_material_and_tasks_1']) ?>
                    @endif
                </td>
                <td style="width: 50%;text-align: left;color: #000;border:1px solid #ccc;word-wrap: break-word;font-size: 14px;" valign="top">
                    @if (!empty($tasks['lessons_tasks_1']))
                        <?php echo nl2br($tasks['lessons_tasks_1']) ?>
                    @endif
                </td>
            </tr>
			
            <tr>
                <td style="width: 50%;text-align: left;color: #000;border:1px solid #ccc;word-wrap: break-word;font-size: 14px;" valign="top">
                    @if (!empty($tasks['lessons_material_and_tasks_2']))
                        <?php echo nl2br($tasks['lessons_material_and_tasks_2'])?>
                    @endif
                </td>
                <td style="width: 50%;text-align: left;color: #000;border:1px solid #ccc;word-wrap: break-word;font-size: 14px;" valign="top">
                    @if (!empty($tasks['lessons_tasks_2']))
                        <?php echo nl2br($tasks['lessons_tasks_2'])?>
                    @endif
                </td>
            </tr>
			
            <tr>
                <td style="width: 50%;text-align: left;color: #000;border:1px solid #ccc;word-wrap: break-word;font-size: 14px;" valign="top">
                   @if (!empty($tasks['lessons_material_and_tasks_3']))
                        <?php echo nl2br($tasks['lessons_material_and_tasks_3']) ?>
                    @endif
                </td>
                <td style="width: 50%;text-align: left;color: #000;border:1px solid #ccc;word-wrap: break-word;font-size: 14px;" valign="top">
                    @if (!empty($tasks['lessons_tasks_3']))
                        <?php echo nl2br($tasks['lessons_tasks_3']) ?>
                    @endif
                </td>
            </tr>
        </table>
		
		<table cellpadding="10" cellspacing="0" style="width: 100%; page-break-before:always;">
			<tr><td colspan="2" height="25"> </td></tr>
			<tr style="background-color: #f4cccc;color: #222;">
				<td style="font-size:15px;line-height:16px;border:1px solid #ccc;">Homework Lesson Materials and Tasks・自習課題</td>
				<td style="font-size:15px;line-height:16px;border:1px solid #ccc;">Next Lesson Tasks・次回のレッスン課題</td>
			</tr>
			<tr>
                <td style="width: 50%;text-align: left;color: #000;border:1px solid #ccc;word-wrap: break-word;font-size: 14px;" valign="top">
                    @if (!empty($tasks['homework_lessons_material_and_tasks_1']))
                        <?php echo nl2br($tasks['homework_lessons_material_and_tasks_1']) ?>
                    @endif
                </td>
                <td style="width: 50%;text-align: left;color: #000;border:1px solid #ccc;word-wrap: break-word;font-size: 14px;" valign="top">
                    @if (!empty($tasks['next_lessons_tasks_1']))
                        <?php echo nl2br($tasks['next_lessons_tasks_1']) ?>
                    @endif
                </td>
            </tr>
			
            <tr>
                <td style="width: 50%;text-align: left;color: #000;border:1px solid #ccc;word-wrap: break-word;font-size: 14px;" valign="top">
                    @if (!empty($tasks['homework_lessons_material_and_tasks_2']))
                        <?php echo nl2br($tasks['homework_lessons_material_and_tasks_2'])?>
                    @endif
                </td>
                <td style="width: 50%;text-align: left;color: #000;border:1px solid #ccc;word-wrap: break-word;font-size: 14px;" valign="top">
                    @if (!empty($tasks['next_lessons_tasks_2']))
                        <?php echo nl2br($tasks['next_lessons_tasks_2'])?>
                    @endif
                </td>
            </tr>
			
            <tr>
                <td style="width: 50%;text-align: left;color: #000;border:1px solid #ccc;word-wrap: break-word;font-size: 14px;" valign="top">
                   @if (!empty($tasks['homework_lessons_material_and_tasks_3']))
                        <?php echo nl2br($tasks['homework_lessons_material_and_tasks_3']) ?>
                    @endif
                </td>
                <td style="width: 50%;text-align: left;color: #000;border:1px solid #ccc;word-wrap: break-word;font-size: 14px;" valign="top">
                    @if (!empty($tasks['next_lessons_tasks_3']))
                        <?php echo nl2br($tasks['next_lessons_tasks_3']) ?>
                    @endif
                </td>
            </tr>
        </table>
    </main>
</body>
</html>


	