<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<section class="mt30">
	
	<div class="fs17 noto600 mb10">슬라이드 만들기</div>
<pre class="html-help">
&lt;div class="<span class="color-red">mySwiper p20</span>" data-per="2.5" data-gap="15" data-loop="false"&gt;
	&lt;div class="<span class="color-red">swiper-container</span>"&gt;
		&lt;div class="<span class="color-red">swiper-wrapper</span>"&gt;
			&lt;div class="<span class="color-red">swiper-slide</span>"&gt;...&lt;/div&gt
			&lt;div class="<span class="color-red">swiper-slide</span>"&gt;...&lt;/div&gt
			&lt;div class="<span class="color-red">swiper-slide</span>"&gt;...&lt;/div&gt
		&lt;/div&gt		
	&lt;/div&gt
&lt;/div&gt
</pre>



	<div class="fs17 noto600 mt80 mb30">버튼 만들기 (버튼명->class) - <span class="fs15 noto400">*기본컬러는 <span class="color-red">[사이트 기본스타일]</span>의 `사이트 메인컬러`</span></div>

	<div class="flex flex-middle gap10">
		<a href="#" class="_btn/sm">_btn/sm</a>
		<a href="#" class="_btn">_btn</a>
		<a href="#" class="_btn/md">_btn/md</a>
		<a href="#" class="_btn/lg">_btn/lg</a>
		<h2 class="fs16 color-red ml15">← 크기 (sm, md, lg)</h2>
	</div>

	<div class="flex flex-middle gap10 mt30">
		<a href="#" class="_btn/lg w-150">_btn w-150</a>
		<a href="#" class="_btn/lg w-190">_btn w-190</a>
		<a href="#" class="_btn/lg w-250">_btn w-250</a>
		<h2 class="fs16 color-red ml15">← 사이즈 (w-full, w-10 ~ w-995, w-10% ~ w-100%)</h2>
	</div>

	<div class="flex flex-middle gap10 mt30">
		<a href="#" class="_btn/rd">_btn/rd</a>
		<a href="#" class="_btn/rd0">_btn/rd0</a>
		<a href="#" class="_btn/rd5">_btn/rd5</a>
		<a href="#" class="_btn/rd8">_btn/rd8</a>
		<a href="#" class="_btn/rd14">_btn/rd14</a>
		<h2 class="fs16 color-red ml15">← 라운딩 (rd, rd0 ~ rd20)</h2>
	</div>

	<div class="flex flex-middle gap10 mt30">		
		<div class="flex column flex-start gap10">
			<div class="flex flex-middle gap10">
				<a href="#" class="_btn/blue">_btn/blue</a>
				<a href="#" class="_btn/red">_btn/red</a>
				<a href="#" class="_btn/green">_btn/green</a>
				<a href="#" class="_btn/black">_btn/black</a>
				<a href="#" class="_btn/yellow">_btn/yellow</a>
				<a href="#" class="_btn/orange">_btn/orange</a>
			</div>
			<div class="flex flex-middle gap10">
				<a href="#" class="_btn/gray">_btn/gray</a>
				<a href="#" class="_btn/gray1">_btn/gray1</a>
				<a href="#" class="_btn/gray2">_btn/gray2</a>
				<a href="#" class="_btn/gray3">_btn/gray3</a>
			</div>
		</div>
		<h2 class="fs16 color-red ml15">← 컬러 (blue, red, green, black, yellow, orange, gray, gray1 ~ gray9)</h2>
	</div>

	<div class="flex flex-middle gap10 mt30">		
		<div class="flex column flex-start gap10">
			<div class="flex flex-middle gap10">
				<a href="#" class="_btn/op9">_btn/op9</a>
				<a href="#" class="_btn/op8">_btn/op8</a>
				<a href="#" class="_btn/op7">_btn/op7</a>
				<a href="#" class="_btn/op6">_btn/op6</a>
				<a href="#" class="_btn/op5">_btn/op5</a>
			</div>
			<div class="flex flex-middle gap10">
				<a href="#" class="_btn/red/op9">_btn/red/op9</a>
				<a href="#" class="_btn/red/op8">_btn/red/op9</a>
				<a href="#" class="_btn/red/op7">_btn/red/op9</a>
				<a href="#" class="_btn/red/op6">_btn/red/op9</a>
				<a href="#" class="_btn/red/op5">_btn/red/op9</a>
			</div>
			<div class="flex flex-middle gap10">
				<a href="#" class="_btn/black/op9">_btn/black/op9</a>
				<a href="#" class="_btn/black/op8">_btn/black/op9</a>
				<a href="#" class="_btn/black/op7">_btn/black/op9</a>
				<a href="#" class="_btn/black/op6">_btn/black/op9</a>
				<a href="#" class="_btn/black/op5">_btn/black/op9</a>
			</div>
			<div class="flex flex-middle gap10">
				<a href="#" class="_btn/black/op4">_btn/black/op4</a>
				<a href="#" class="_btn/black/op3">_btn/black/op3</a>
				<a href="#" class="_btn/black/op2">_btn/black/op2</a>
				<a href="#" class="_btn/black/op1">_btn/black/op1</a>
			</div>
		</div>
		<h2 class="fs16 color-red ml15">← 투명도 (op9 ~ op1)</h2>
	</div>

	<div class="flex flex-middle gap10 mt30">
		<a href="#" class="_btn/line">_btn/line</a>
		<a href="#" class="_btn/line/mainColor">_btn/line/mainColor</a>
		<a href="#" class="_btn/blue/line">_btn/blue/line</a>
		<a href="#" class="_btn/red/line">_btn/red/line</a>
		<a href="#" class="_btn/green/line">_btn/green/line</a>
		<a href="#" class="_btn/black/line">_btn/black/line</a>
		<a href="#" class="_btn/yellow/line">_btn/yellow/line</a>
		<a href="#" class="_btn/orange/line">_btn/orange/line</a>
		<h2 class="fs16 color-red ml15">← 라인 (line)</h2>
	</div>

	<div class="flex flex-middle gap10 mt30">
		<a href="#" class="_btn/line/hover">_btn/line/hover</a>
		<a href="#" class="_btn/line/mainColor/hover">_btn/line/hover</a>
		<a href="#" class="_btn/blue/line/hover">_btn/blue/line/hover</a>
		<a href="#" class="_btn/red/line/hover">_btn/red/line/hover</a>
		<a href="#" class="_btn/green/line/hover">_btn/green/line/hover</a>
		<a href="#" class="_btn/black/line/hover">_btn/black/line/hover</a>
		<a href="#" class="_btn/yellow/line/hover">_btn/yellow/line/hover</a>
		<a href="#" class="_btn/orange/line/hover">_btn/orange/line/hover</a>
		<h2 class="fs16 color-red ml15">← 라인(호버) (line/hover)</h2>
	</div>



	<div class="fs17 noto600 mt100 mb30">폰트 종류 (class)</div>
	<div class="flex flex-middle gap10 mt30 fs15">
		<span class="_tag/blue mr20 SCoreDream">나눔스퀘어라운드</span>
		<p class="nanumSR">nanumSR</p>
		<p class="nanumSR100">nanumSR100</p>
		<p class="nanumSR200">nanumSR200</p>
		<p class="nanumSR300">nanumSR300</p>
		<p class="nanumSR400">nanumSR400</p>
		<p class="nanumSR500">nanumSR500</p>
		<p class="nanumSR600">nanumSR600</p>
		<p class="nanumSR700">nanumSR700</p>
		<p class="nanumSR800">nanumSR800</p>
	</div>
	<div class="flex flex-middle gap10 mt15 fs15">
		<span class="_tag/blue mr20 SCoreDream">본고딕</span>
		<p class="noto">noto</p>
		<p class="noto100">noto100</p>
		<p class="noto200">noto200</p>
		<p class="noto300">noto300</p>
		<p class="noto400">noto400</p>
		<p class="noto500">noto500</p>
		<p class="noto600">noto600</p>
		<p class="noto700">noto700</p>
		<p class="noto800">noto800</p>
	</div>
	<div class="flex flex-middle gap10 mt15 fs15">
		<span class="_tag/blue mr20 SCoreDream">블랙 한산 고딕</span>
		<p class="blackGothic fs20">blackGothic</p>
	</div>
	<div class="flex flex-middle gap10 mt15 fs15">
		<span class="_tag/blue mr20 SCoreDream">도현체</span>
		<p class="dohyeon fs20">dohyeon</p>
	</div>
	<div class="flex flex-middle gap10 mt15 fs15">
		<span class="_tag/blue mr20 SCoreDream">맑은고딕</span>
		<p class="malgunGothic">malgunGothic</p>
		<p class="malgunGothic100">malgunGothic100</p>
		<p class="malgunGothic200">malgunGothic200</p>
		<p class="malgunGothic300">malgunGothic300</p>
		<p class="malgunGothic400">malgunGothic400</p>
		<p class="malgunGothic500">malgunGothic500</p>
		<p class="malgunGothic600">malgunGothic600</p>
		<p class="malgunGothic700">malgunGothic700</p>
	</div>
	<div class="flex flex-middle gap10 mt15 fs15">
		<span class="_tag/blue mr20 SCoreDream">나눔고딕</span>
		<p class="nanum">nanum</p>
		<p class="nanum-bold">nanum-bold</p>
	</div>
	<div class="flex flex-middle gap10 mt15 fs15">
		<span class="_tag/blue mr20 SCoreDream">에스코어드림</span>
		<p class="SCoreDream">SCoreDream</p>
		<p class="SCoreDream100">SCoreDream100</p>
		<p class="SCoreDream200">SCoreDream200</p>
		<p class="SCoreDream300">SCoreDream300</p>
		<p class="SCoreDream400">SCoreDream400</p>
		<p class="SCoreDream500">SCoreDream500</p>
		<p class="SCoreDream600">SCoreDream600</p>
		<p class="SCoreDream700">SCoreDream700</p>
	</div>
	<div class="flex flex-middle gap10 mt15 fs15">
		<span class="_tag/blue mr20 mont">몬세라트</span>
		<p class="mont">mont</p>
		<p class="mont100">mont100</p>
		<p class="mont200">mont200</p>
		<p class="mont300">mont300</p>
		<p class="mont400">mont400</p>
		<p class="mont500">mont500</p>
		<p class="mont600">mont600</p>
		<p class="mont700">mont700</p>
	</div>


	<div class="fs17 noto600 mt100 mb30">폰트 사이즈 (class) - 예시폰트는 나눔스퀘어라운드</div>
	<div class="flex flex-middle gap10 mt30 fs15">
		<p class="nanumSR fs9">fs9</p>
		<p class="nanumSR fs10">fs10</p>
		<p class="nanumSR fs11">fs11</p>
		<p class="nanumSR fs12">fs12</p>
		<p class="nanumSR fs13">fs13</p>
		<p class="nanumSR fs14">fs14</p>
		<p class="nanumSR fs15">fs15</p>
		<p class="nanumSR fs20">fs20</p>
		...
		<p class="nanumSR fs30">fs30</p>
		...
		<p class="nanumSR fs40">fs40</p>
		...
		<p class="nanumSR fs60">fs60</p>
	</div>

</section>
