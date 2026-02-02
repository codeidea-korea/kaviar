



$(document).ready(function(){

	//shop header 스크롤 이벤트 ──────────────────────────────────────────────────────
	if($('#header.scrollTrigger').length) {
		const showAnim = gsap.from('#header.scrollTrigger #header_inwrap', {
			yPercent: -100,
			paused: true,
			duration: 0.2
		}).progress(1);
		ScrollTrigger.create({
			start: "top top-=100",
			//end: 99999,
			end: "bottom bottom+=10px",
			//toggleClass: {targets: "#header.scrollTrigger", className: "scrollTriggerActive"},
			onLeave: function() {
				showAnim.play();
			},
			onUpdate: (self) => {
				self.direction === -1 ? showAnim.play() : showAnim.reverse()
			}	
		});

		/*const tabShowAnim = gsap.from('#v_tabContainer', {
			yPercent: -120,
			paused: true,
			duration: 0.2
		}).progress(1);
		ScrollTrigger.create({
			trigger: "#v_tabContainer",
			start: "-=30px top top",
			end: 99999,
			onUpdate: (self) => {
				self.direction === -1 ? tabShowAnim.play() : tabShowAnim.reverse()
			}
		});*/
	}
	if($('#header.scrollTrigger2').length) {
		let headerCon_height = $('#header .headerContainer').height();
		const showAnim = gsap.from('#header.scrollTrigger2 #header_inwrap', {
			y: -headerCon_height,
			paused: true,
			duration: 0.2
		}).progress(1);
		ScrollTrigger.create({
			start: "top top-=100",
			end: "bottom bottom+=10px",
			onLeave: function() {
				showAnim.play();
			},
			onUpdate: (self) => {
				self.direction === -1 ? showAnim.play() : showAnim.reverse()
			}	
		});
	}

	//하단 메뉴 스크롤 이벤트 ──────────────────────────────────────────────────────
	if($('#bottomTabMenu.scrollTrigger').length) {
		const showAnim = gsap.from('#bottomTabMenu.scrollTrigger', {
			yPercent: 100,
			paused: true,
			duration: 0.2
		}).progress(1);
		ScrollTrigger.create({
			start: "top top",
			//end: 99999,
			end: "bottom bottom+=10px",
			onLeave: function() {
				showAnim.play()
			},
			onUpdate: (self) => {
				self.direction === -1 ? showAnim.play() : showAnim.reverse()
			}	
		});
	}

});