package cj.video {
	
	import flash.display.Sprite;
	import flash.events.MouseEvent;
	import flash.events.Event;
	
	import cj.video.events.VideosEvent;
	
	public class VideoBtn extends Sprite {
		
		private var namer:String;
		
		public function VideoBtn(st:String) {
			
			namer = st;
			
			this.buttonMode = true;
			addEventListener(MouseEvent.CLICK, clicked);
			addEventListener(Event.REMOVED_FROM_STAGE, removed);
			
		}
		
		private function removed(event:Event):void {
			
			removeEventListener(MouseEvent.CLICK, clicked);
			removeEventListener(Event.REMOVED_FROM_STAGE, removed);
			
			while(this.numChildren) {
				removeChildAt(0);
			}
			
		}
		
		private function clicked(event:MouseEvent):void {
			
			var xx:int = namer != "totalLine" ? this.mouseX : this.parent.mouseX - this.x + 15;
			
			dispatchEvent(new VideosEvent(VideosEvent.CLICKED, namer, xx));
			
		}

	}
	
}
