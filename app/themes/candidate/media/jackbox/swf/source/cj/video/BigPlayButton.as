package cj.video  {
	
	import flash.display.Sprite;
	import flash.events.Event;
	import flash.events.MouseEvent;
	
	import fl.transitions.Tween;
	import fl.transitions.easing.Strong;
	
	import cj.video.events.VideosEvent;
	
	public final class BigPlayButton extends Sprite {
		
		private var isPlaying:Boolean,
		tw:Tween;
		
		public function BigPlayButton(auto:Boolean) {
			
			isPlaying = auto;
			
			if(isPlaying) {
				
				this.alpha = 0;
				this.mouseEnabled = false;
				
			}
			else {
				
				this.buttonMode = true;
				
			}
			
			addEventListener(Event.ADDED_TO_STAGE, added);
			
		}
		
		private function added(event:Event):void {
			
			removeEventListener(Event.ADDED_TO_STAGE, added);
			
			sizer();
			stage.addEventListener(Event.RESIZE, sizer, false, 0, true);
			
			addEventListener(MouseEvent.CLICK, clicked);
			addEventListener(Event.REMOVED_FROM_STAGE, removed);
			
		}
		
		private function sizer(event:Event = null):void {
			
			this.x = stage.stageWidth >> 1;
			this.y = stage.stageHeight >> 1;
			
		}
		
		private function clicked(event:MouseEvent):void {
			
			event.stopPropagation();
			
			if(!isPlaying) dispatchEvent(new VideosEvent(VideosEvent.CLICKED, "playBtn", 0));
			
		}
		
		internal function playIt():void {
			
			this.buttonMode = this.mouseEnabled = false;
			
			isPlaying = true;
			
			if(tw != null) tw.stop();
			tw = new Tween(this, "alpha", Strong.easeOut, this.alpha, 0, 0.75, true);
			
		}
		
		internal function pauseIt(event:MouseEvent = null):void {
			
			this.buttonMode = this.mouseEnabled = true;
			
			isPlaying = false;
			
			if(tw != null) tw.stop();
			tw = new Tween(this, "alpha", Strong.easeOut, this.alpha, 1, 0.75, true);
			
		}
		
		private function removed(event:MouseEvent):void {
			
			removeEventListener(Event.REMOVED_FROM_STAGE, removed);
			removeEventListener(MouseEvent.CLICK, clicked);
			removeEventListener(Event.ADDED_TO_STAGE, added);
			
			if(tw != null) {
				
				tw.stop();
				tw = null;
				
			}
			
			if(stage != null) stage.removeEventListener(Event.RESIZE, sizer);
			
		}

	}
	
}










