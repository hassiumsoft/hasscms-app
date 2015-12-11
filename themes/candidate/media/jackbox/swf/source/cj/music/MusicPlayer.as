package cj.music {
	
	// import events
	import flash.display.Sprite;
	import flash.events.Event;
	import flash.events.IOErrorEvent;
	import flash.media.Sound;
	import flash.media.SoundChannel;
	import flash.media.SoundTransform;
	import flash.external.ExternalInterface;
	import flash.net.URLRequest;
	
	// Document Class for the Music Player
	public final class MusicPlayer extends Sprite {
		
		private var song:Sound;
		private var channel:SoundChannel;
		private var soundTrans:SoundTransform;
		private var position:Number;
		private var theSong:String;
		private var songLoaded:Boolean;
		
		// class constructor
		public function MusicPlayer() {
			
			addEventListener(Event.UNLOAD, removed);
			(stage == null) ? addEventListener(Event.ADDED_TO_STAGE, added) : added();
			
		}
		
		// fires when the stage becomes available
		private function added(event:Event = null):void {
			
			if(event != null) removeEventListener(Event.ADDED_TO_STAGE, added);
			
			position = 0;
			songLoaded = false;
			
			song = new Sound();
			song.addEventListener(IOErrorEvent.IO_ERROR, catchError);
			
			if(ExternalInterface.available) {
				
				ExternalInterface.addCallback("storeVars", storeVars);
				ExternalInterface.addCallback("togglePlayPause", togglePlayPause);
			}
					  
			addEventListener(Event.REMOVED_FROM_STAGE, removed);
		
		}
		
		// data passed from JavaScript
		private function storeVars(url:String, vol:Number):void {
			
			soundTrans = new SoundTransform(vol);
			theSong = url;
		
		}
		
		// toggles play/pause
		private function togglePlayPause(toPlay:Boolean):void {
			
			if(!toPlay) {
				
				if(songLoaded) {
					
					position = channel.position;
					channel.stop();
					
				}
				
			}
			else {
				
				if(!songLoaded) {
					
					songLoaded = true;
					song.load(new URLRequest(theSong));
					
				}
				
				playSong();
				
			}
			
		}
		
		private function songEnded(event:Event):void {

			position = 0;
			playSong();
			
		}
		
		// catches loading errors
		private function catchError(event:IOErrorEvent):void {};
		
		// plays the song
		private function playSong():void {
			
			channel = song.play(position);
			channel.soundTransform = soundTrans;
			channel.addEventListener(Event.SOUND_COMPLETE, songEnded);
			
		}
		
		// garbage collection
		private function removed(event:Event):void {
			
			removeEventListener(Event.UNLOAD, removed);
			removeEventListener(Event.REMOVED_FROM_STAGE, removed);
			removeEventListener(Event.ADDED_TO_STAGE, added);
			
			if(song != null) {
				
				if(channel != null) {
					
					channel.removeEventListener(Event.SOUND_COMPLETE, songEnded);
					channel.stop();
					channel = null;
					
				}
				
				try {
					song.close();
				}
				catch(event:*){};
				
				song.removeEventListener(IOErrorEvent.IO_ERROR, catchError);
				
				song = null;
				soundTrans = null;
				
			}
			
		}

	}
	
}






















