package cj.video.events {

	import flash.events.Event;
	
	// custom event for toggling the audio
	public final class VideosEvent extends Event {
     		
		public static const CLICKED:String = "clicked";
		
		public var item:String;
		public var xx:int;
		
		public function VideosEvent(type:String, namer:String, theX:int) {
		
			super(type, true);
			
			item = namer;
			xx = theX;
		
		}
		
		public override function clone():Event {
		
			return new VideosEvent(VideosEvent.CLICKED, item, xx);
		
		}
		
	}

}





