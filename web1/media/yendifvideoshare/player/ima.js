/**
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
'use strict';
var autoplayAllowed = false;
var autoplayRequiresMute = false;
var player;
var wrapperDiv;


var yendifIma = function( player,  imaAds ) {
	
	this.player = player;
	var id  = 'yvsplayer';
	var imaAds = imaAds;
		autoplayAllowed = imaAds.autoplay;
	
	// Remove controls from the player on iPad to stop native controls from stealing
	// our click
	var contentPlayer =  document.getElementById( id  );
	if (( navigator.userAgent.match( /iPad/i ) || navigator.userAgent.match( /Android/i ) ) && contentPlayer.hasAttribute( 'controls' ) ) {
		contentPlayer.removeAttribute('controls');
	}
	
	// Start ads when the video player is clicked, but only the first time it's
	// clicked.
	this.startEvent = 'click';
		if ( navigator.userAgent.match( /iPhone/i ) || navigator.userAgent.match( /iPad/i ) || navigator.userAgent.match( /Android/i ) ) {
		this.startEvent = 'touchend';
	}
	
	this.wrapperDiv = document.getElementById( id );
	this.boundInitFromStart = this.initFromStart.bind( this );
	this.wrapperDiv.addEventListener( this.startEvent, this.initFromStart.bind( this ) );

	this.options = {
		id: id,
		autoplay: autoplayAllowed,
		muted: autoplayRequiresMute,
		disableCustomPlaybackForIOS10Plus: true,
		//prerollTimeout: 1000,
		adTagUrl: imaAds.imaAdTagUrl, 
		debug: false,
		imaVpaidMode: 'enabled',	
		imaLiveStreamAdInterval: 300,
		adsManagerLoadedCallback: this.adsManagerLoadedCallback.bind( this )
	};
	
	
	this.contents = '';
	this.posters = '';
	this.currentContent = 0;
	this.linearAdPlaying = false;
	this.initialized = false;
	this.playlistItemClicked = false;
	
	this.playlistDiv = document.getElementsByClassName( 'vjs-playlist' );

	
	this.autoplayRequested = this.options.autoplay && 'false' !== this.options.autoplay;
	
	this.player.ima( this.options );

}

yendifIma.prototype.initFromStart = function() {
  if ( !this.initialized ) {
    this.init();
    this.wrapperDiv.removeEventListener( this.startEvent, this.boundInitFromStart );
  }
}

yendifIma.prototype.init = function() {
  this.initialized = true;
  this.player.ima.initializeAdDisplayContainer();
  
};

yendifIma.prototype.adsManagerLoadedCallback = function() {
  var events = [google.ima.AdEvent.Type.ALL_ADS_COMPLETED,
                google.ima.AdEvent.Type.CLICK,
                google.ima.AdEvent.Type.COMPLETE,
                google.ima.AdEvent.Type.CONTENT_PAUSE_REQUESTED,
                google.ima.AdEvent.Type.CONTENT_RESUME_REQUESTED,
                google.ima.AdEvent.Type.FIRST_QUARTILE,
                google.ima.AdEvent.Type.LOADED,
                google.ima.AdEvent.Type.MIDPOINT,
                google.ima.AdEvent.Type.PAUSED,
                google.ima.AdEvent.Type.STARTED,
                google.ima.AdEvent.Type.THIRD_QUARTILE];
  for (var index = 0; index < events.length; index++) {
    this.player.ima.addEventListener(
        events[index],
        this.onAdEvent.bind(this));
  }
  


  // When the page first loads, don't autoplay. After that, when the user
  // clicks a playlist item to switch videos, autoplay.
  if ( this.playlistItemClicked ) {
    	this.player.play();
  }
  
};

yendifIma.prototype.onAdEvent = function( event ) {
	//console.log( 'EventType='+ event.type );
  if ( event.type == google.ima.AdEvent.Type.CONTENT_PAUSE_REQUESTED ) {
    this.linearAdPlaying = true;
  } else if ( event.type == google.ima.AdEvent.Type.CONTENT_RESUME_REQUESTED ) {
    this.linearAdPlaying = false;
  } else {
    //this.console.innerHTML = this.console.innerHTML + '<br/>Ad event: ' + event.type;
  }
};

/**
 * Check if HTML5 video autoplay is supported.
 */
(function () {
		   
    var autoplayAllowed, autoplayRequiresMuted;
	
	var videoElement = document.createElement( 'video' );
	videoElement.id = 'yvs-video-hidden';
    videoElement.src = "data:video/mp4;base64,AAAAFGZ0eXBNU05WAAACAE1TTlYAAAOUbW9vdgAAAGxtdmhkAAAAAM9ghv7PYIb+AAACWAAACu8AAQAAAQAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAgAAAnh0cmFrAAAAXHRraGQAAAAHz2CG/s9ghv4AAAABAAAAAAAACu8AAAAAAAAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAABAAAAAAFAAAAA4AAAAAAHgbWRpYQAAACBtZGhkAAAAAM9ghv7PYIb+AAALuAAANq8AAAAAAAAAIWhkbHIAAAAAbWhscnZpZGVBVlMgAAAAAAABAB4AAAABl21pbmYAAAAUdm1oZAAAAAAAAAAAAAAAAAAAACRkaW5mAAAAHGRyZWYAAAAAAAAAAQAAAAx1cmwgAAAAAQAAAVdzdGJsAAAAp3N0c2QAAAAAAAAAAQAAAJdhdmMxAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAAAAFAAOABIAAAASAAAAAAAAAABAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAGP//AAAAEmNvbHJuY2xjAAEAAQABAAAAL2F2Y0MBTUAz/+EAGGdNQDOadCk/LgIgAAADACAAAAMA0eMGVAEABGjuPIAAAAAYc3R0cwAAAAAAAAABAAAADgAAA+gAAAAUc3RzcwAAAAAAAAABAAAAAQAAABxzdHNjAAAAAAAAAAEAAAABAAAADgAAAAEAAABMc3RzegAAAAAAAAAAAAAADgAAAE8AAAAOAAAADQAAAA0AAAANAAAADQAAAA0AAAANAAAADQAAAA0AAAANAAAADQAAAA4AAAAOAAAAFHN0Y28AAAAAAAAAAQAAA7AAAAA0dXVpZFVTTVQh0k/Ou4hpXPrJx0AAAAAcTVREVAABABIAAAAKVcQAAAAAAAEAAAAAAAAAqHV1aWRVU01UIdJPzruIaVz6ycdAAAAAkE1URFQABAAMAAAAC1XEAAACHAAeAAAABBXHAAEAQQBWAFMAIABNAGUAZABpAGEAAAAqAAAAASoOAAEAZABlAHQAZQBjAHQAXwBhAHUAdABvAHAAbABhAHkAAAAyAAAAA1XEAAEAMgAwADAANQBtAGUALwAwADcALwAwADYAMAA2ACAAMwA6ADUAOgAwAAABA21kYXQAAAAYZ01AM5p0KT8uAiAAAAMAIAAAAwDR4wZUAAAABGjuPIAAAAAnZYiAIAAR//eBLT+oL1eA2Nlb/edvwWZflzEVLlhlXtJvSAEGRA3ZAAAACkGaAQCyJ/8AFBAAAAAJQZoCATP/AOmBAAAACUGaAwGz/wDpgAAAAAlBmgQCM/8A6YEAAAAJQZoFArP/AOmBAAAACUGaBgMz/wDpgQAAAAlBmgcDs/8A6YEAAAAJQZoIBDP/AOmAAAAACUGaCQSz/wDpgAAAAAlBmgoFM/8A6YEAAAAJQZoLBbP/AOmAAAAACkGaDAYyJ/8AFBAAAAAKQZoNBrIv/4cMeQ==";    
    videoElement.autoplay = true;
    videoElement.style.position = 'fixed';
    videoElement.style.left = '5000px';

   	document.getElementsByTagName( 'body' )[0].appendChild( videoElement );
	var videoContent = document.getElementById( 'yvs-video-hidden' );
	
	function checkAutoplaySupport() {
		// Check if autoplay is supported.
  		var playPromise = videoContent.play();
  		if ( playPromise !== undefined ) {
    		playPromise.then( onAutoplayWithSoundSuccess ).catch( onAutoplayWithSoundFail );
  		} else {
			autoplayAllowed = false;
  			autoplayRequiresMuted = false;
  			autoplayChecksResolved();
		}
	}

	function onAutoplayWithSoundSuccess() {
  		// If we make it here, unmuted autoplay works.
  		videoContent.pause();
  		autoplayAllowed = true;
  		autoplayRequiresMuted = false;
  		autoplayChecksResolved();
	}

	function onAutoplayWithSoundFail() {
  		// Unmuted autoplay failed. Now try muted autoplay.
  		checkMutedAutoplaySupport();
	}

	function checkMutedAutoplaySupport() {
  		videoContent.volume = 0;
  		videoContent.muted = true;
  		var playPromise = videoContent.play();
  		if ( playPromise !== undefined ) {
    		playPromise.then( onMutedAutoplaySuccess ).catch( onMutedAutoplayFail );
  		}
	}

	function onMutedAutoplaySuccess() {
  		// If we make it here, muted autoplay works but unmuted autoplay does not.
  		videoContent.pause();
  		autoplayAllowed = true;
  		autoplayRequiresMuted = true;
  		autoplayChecksResolved();
	}

	function onMutedAutoplayFail() {
  		// Both muted and unmuted autoplay failed. Fall back to click to play.
  		videoContent.volume = 1;
  		videoContent.muted = false;
  		autoplayAllowed = false;
  		autoplayRequiresMuted = false;
  		autoplayChecksResolved();
	}
	
	function autoplayChecksResolved() {
		document.getElementsByTagName( 'body' )[0].removeChild( videoElement );
		
		// Announce to the World!
		window.imaAutoplayChecksResolved = true;
	 	window.imaAutoplayAllowed = autoplayAllowed;
		window.imaAutoplayRequiresMuted = autoplayRequiresMuted;
	};	
	
	// ...
	checkAutoplaySupport();
	
})();


