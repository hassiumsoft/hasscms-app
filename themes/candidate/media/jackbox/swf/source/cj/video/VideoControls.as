package cj.video {
	
	import flash.display.Sprite;
	import flash.display.MovieClip;
	import flash.text.TextFormat;
	import flash.events.Event;
	
	public final class VideoControls extends Sprite {
		
		private var kicked:Function;
		private var theVolume:Number;
		
		public function VideoControls(kicker:Function, myVolume:Number) {
			
			kicked = kicker;
			theVolume = myVolume;
			
			addEventListener(Event.ADDED_TO_STAGE, added);
			
		}
		
		
		private function added(event:Event):void {
			
			removeEventListener(Event.ADDED_TO_STAGE, added);
			
			sizer();
			progressLine.scaleX = 0;
			
			rightSide.fullOff.visible = false;
			rightSide.volOff.visible = false;
			rightSide.volLevel.scaleX = theVolume;
			rightSide.volLevel.mouseEnabled = progressLine.mouseEnabled = progressLine.mouseChildren = this.mouseEnabled = false;
			
			playOff();
			
			kicked(progressLine, rightSide.volLevel, rightSide.volTotal.width);
			kicked = null;
			
			myText.mask = timeMask;
			
			addEventListener(Event.REMOVED_FROM_STAGE, removed);
			stage.addEventListener(Event.RESIZE, sizer, false, 0, true);
			
		}
		
		private function sizer(event:Event = null):void {
			
			var sw:int = stage.stageWidth, vMinus:int = sw - 237;
			
			rightSide.x = totalLine.x + vMinus + 12;
			progressLine.inside.width = totalLine.width = vMinus;
			
			bg.controlBg.width = sw;
			
		}
		
		internal function fsOff():void {
			
			rightSide.fullOn.visible = true;
			rightSide.fullOff.visible = false;
			
		}
		
		internal function fsOn():void {

			rightSide.fullOff.visible = true;
			rightSide.fullOn.visible = false;
			
		}
		
		internal function playOn():void {
			
			playBtn.visible = false;
			pauseBtn.visible = true;
			
		}
		
		internal function playOff():void {
			
			pauseBtn.visible = false;
			playBtn.visible = true;
			
		}
		
		internal function volumeOn():void {
			
			rightSide.volOff.visible = true;
			rightSide.volOn.visible = false;
			rightSide.volLevel.visible = false;
			
		}
		
		internal function volumeOff():void {
			
			rightSide.volOn.visible = true;
			rightSide.volOff.visible = false;
			rightSide.volLevel.visible = true;
			
		}
		
		private function removed() {
			
			removeEventListener(Event.ADDED_TO_STAGE, added);
			removeEventListener(Event.REMOVED_FROM_STAGE, removed);
			
			if(stage != null) stage.removeEventListener(Event.RESIZE, sizer);
			while(this.numChildren) removeChildAt(0);
			
			kicked = null;
			
		}
		
	}
	
}









