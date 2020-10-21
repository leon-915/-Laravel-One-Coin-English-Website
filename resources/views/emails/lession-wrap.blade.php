@extends('emails.layout')
@section('title')
		<title>OnePage wrapped successfully </title>
@endsection
@section('content')
		<h1 style="font-size: 25px; color: #212529; font-weight: 500; margin: 0; padding: 20px 0;">OnePage wrapped successfully </h1>
		<div class="course" style="padding-bottom: 25px;">
				<table style="width: 100%;  max-width: 70%;  margin-bottom: 1rem;  margin: 0 auto; text-align: left;">
						<tbody>
						<tr>
							<td>
								<?php
								$message = ucfirst($data['student']['firstname']) . ' ' . ucfirst($data['student']['lastname']) . " 様<br><br>";
								$message .= ucfirst($data['teacher']['firstname'])."  によるAccentのレッスンを受講していただき、ありがとうございます。英語力アップに向けて、今後も一緒にがんばっていきましょう。<br><br>";
								$message .= '英語は、何度も使うことで身についていきます。今回学んだ内容を積極的に使うよう意識してみてください。<br>';
								$message .= '英語から日本語に翻訳するのではなく、英語のままインプットし、英語でアウトプットする練習をしましょう。<br>';
								$message .= 'テキストを見ずに、センテンスを声に出して言ってみましょう。すらすら言えるようになるまで繰り返し練習してください。<br><br>';
								$message .= '何かを習得する最大のコツは、良い習慣を身につけることです。<br><br>';
								$message .= '今回のレッスンのOnePageを見るには、 Accent OnePage Report ( ' . $data['site_url'] . '/student/onepage/ ) にアクセスし、ログインしてください。<br>';
								$message .= '英語でも日本語 でも検索できるので 過去のレッスンのコンテンツも簡単に見つけることができます。<br><br>';
								$message .= 'ログインしていない状態が3日間続くと セキュリティ保護のため自動的にログアウトされます。<br><br>';
								echo $message .= 'Accentのパスワードをお忘れになった場合は、ログインページのログインボタンの下にあるパスワードを忘れた場合はこちらにアクセスしてください。<br><br>';
								?>
							</td>
						</tr>

					 </tbody>
			 </table>
		</div>

@endsection
