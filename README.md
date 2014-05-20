# ViewMedica 7 API Documentation

1. [Terminology](#terminology)
2. [Help Links](#help-links)
3. [Using the Player](#using-the-player)
4. [Embed Variables](#embed-variables)
5. [Controlling the Player](#controlling-the-player)
6. [Global Functions](#global-functions)
7. [Information Requests](#information-requests)
8. [Creating/Retrieving a Client](#client-information)

### Terminology

*Menu Structure*

1. Library - The top level taxonomy item in ViewMedica 7.
2. Collection - Subcategorizes libraries. For example, there are many collections in a library. If a collection is to be skipped, it is given the same name as the library.
3. Group - Typically groups are divided into either Procedures, Conditions, and Surgical Procedures/Non-surgical Procedures.
4. Item - A ViewMedica content item that can be viewed by the end user.

*Player Versions*

1. ViewMedica 7 - refers to the suite of both ViewMedica Flash and ViewMedica HTML. It is an attempt to have a version of ViewMedica which is supported on all devices.
2. ViewMedica HTML - The JavaScript and HTML version of ViewMedica which was released in 2013. This version of ViewMedica is being actively developed.
3. ViewMedica Flash - The deprecated version of ViewMedica which is written in ActionScript. This player is no longer supported but is maintained for supporting video playback in IE8 and lower.
4. ViewMedica Mobile - A paid service which allows users to play videos from their device without an internet connection. It can be downloaded from the App Store. Mirroring is also required and can be purchased from the user's viewmedica.com account.
5. ViewMedica DVD/CCTV - Products for in-office or waiting room use of the ViewMedica player and require no internet connection.

### Help Links

The standard ViewMedica documentation can be found at https://swarminteractive.com/viewmedica-support.html. This documentation is intended for users who are writing custom applications which utilize the ViewMedica player.

### Using the Player

*A vm_open function call is dispatched to indicate that the ViewMedica player should use all of the currently set global variables and write the player interface to the targeted div. Variables will still persist after the vm_open function has been called, so future players can be opened by simply changing the openthis value, although our standard embed gives all values for user convenience.*

```
ex.
vm_open();
```

### Embed Variables

*A basic embed is listed below to give context for the rest of the configuration options. This embed will open the ViewMedica 7 viewer in its default state with navigation menus.*

```
<!-- ViewMedica Embed Start -->
<div id="vm"></div>
<script type="text/javascript" src="https://www.swarminteractive.com/js/vm.js"></script>
<script type="text/javascript">client="1234"; width=580; vm_open();</script>
<!-- ViewMedica Embed End -->
```

- __Client ID__ *string*

Global variable which loads a preferences file into the ViewMedica viewer. All of these preferences can be overridden through embed variables. It is also used to determine what content a particular user has available.

```
ex.
client="1234";
```

- __Language__ *string*

Sets the language of the ViewMedica 7 viewer. This will override any option that has been selected through the users ViewMedica preferences panel at viewmedica.com. Only video items that have been translated in the selected language will be visible.

```
ex.
lang="es";
```

- __Width__ *int*

Sets the with of the ViewMedica player. The height will automatically be calculated from this value so that videos fit appropriately within the ViewMedica player.

```
ex.
width=580;
```

- __Openthis__ *string*

Tells the ViewMedica player either:

- which content item it should open to and open in video mode
- which library, collection, or group it should open to

A full list of openthis codes can be found in your viewmedica.com account under installation support.

```
ex.
openthis="A_123456"; //a video always starts with A_
openthis="L_123456"; //menu item locations may begin with L_ C_ or G_
```

- __Target__ *string*

Override the empty element that the ViewMedica player will be inserted in to. By default, the target is the same as the openthis code.

```
ex.
target_div="my_custom_div_id";
```

- __Disclaimer__ *boolean*

Whether or not the disclaimer should appear in the lower menu bar of the ViewMedica player.

```
ex.
disclaimer=false;
```

- __Menu Access__ *boolean*

By default, When the player is opened to video mode, users can exit the video interface and return to the default menu structure. Setting menuaccess to false disables these buttons and the player will always remain in single video mode.

```
ex.
menuaccess=false;
```

- __Captions__ *boolean*

Hide the closed captions toggle button.

```
ex.
captions=false;
```

- __Social__ *boolean*

Hide the social sharing (email, facebook, twitter) button.

```
ex.
social=false;
```

- __Secure__ *boolean*

Load all assets over HTTPS. By default, the ViewMedica player does not require a secure connection.

```
ex.
secure=true;
```

- __Ignore Audio__ *boolean*

The player is loaded in a muted state by default.

```
ex.
ignoreaudio=true;
```

- __Brochures__ *boolean*

Do not show the brochure printing buttons.

```
ex.
brochures=false;
```

- __Full Screen__ *boolean*

Hide the button which toggles full screen mode. This can be useful if the player is in a restricted iFrame and cannot be sized properly.

```
ex.
fullscreen=false;
```

### Controlling the Player

The ViewMedica player has a front-end API that allows for JavaScript control of the player. It also allows you to retrieve information about the player's current state, such as how long the current video is and what its current position is.

By default after a vm_open is called, the player assigns the ViewMedica API to a global object _vm. You can use this object to control the player or create your own. Typically, this would only be necessary if you had multiple ViewMedica embeds on the same page.

```
// pass the div ID that contains viewmedica create a new vm api object
// or you can use the globally assigned _vm object if there is only one video on that page

var my_viewmedica = new VM_PLAYER('A_123456');
```

__Events__

*You can add event listeners that will be triggered by the ViewMedica player when certain points are reached. It is recommended to attach these listeners to the div element that contains ViewMedica, which is accessible through the global VM_PLAYER object.*

- __API Ready Event__

```
// add event listener for when the viewmedica api is ready to be used
// and the player is completely loaded

_vm.container.addEventListener('onReady', function(e) {
    console.log("VM API Ready");
    console.log(e.detail);
});
```

- __Playback State Change__

```
// event fires when the player's video state changes

_vm.container.addEventListener('onStateChange', function(e) {
    // true if player video is ready
    console.log( _vm.getPlayerState() === _vm.states.READY );
});
```

- __Caption Change__

```
// event fires when the player's caption changes

_vm.container.addEventListener('onCaptionChange', function(e) {
    console.log( _vm.getCaption() );
});
```

- __Volume Change__

```
// event fires when the player's volume changes

_vm.container.addEventListener('onVolumeChange', function(e) {
    console.log( _vm.getVolume() );
});
```

__Retrieve Player Information__

Information about the video is available once the player is ready, so it will need to be retrieve after the appropriate event is fired.

- __Video Duration__

```
_vm.container.addEventListener('onStateChange', function(e) {
    if (_vm.getPlayerState() === _vm.states.READY) {
        var duration = _vm.getDuration();
        console.log(duration);
    }
});
```

- __Video Current Time__

```
var time = _vm.getCurrentTime();
console.log(time);
```

- __Playback State__

```
_vm.container.addEventListener('onStateChange', function(e) {
    var state = _vm.getPlayerState();

    /* All Playback States
     * _vm.states.WAITING: -1,
     * _vm.states.READY: 0,
     * _vm.states.PLAYING: 1,
     * _vm.states.PAUSED: 2
     */
});
```

- __Caption__

```
_vm.container.addEventListener('onCaptionChange', function(e) {
    var caption = _vm.getCaption();
    console.log(caption);
});
```

- __Volume__

```
_vm.container.addEventListener('onVolumeChange', function(e) {
    var volume = _vm.getVolume();
    console.log(volume);
});
```

__Functions to Control Playback__

- __Navigate to a Video__

```
// exits the current video and moves to the location specified.
// the load screen will appear until the location is succesfully loaded, however, the player will not actually reload

_vm.navigate("A_123456");
```

- __Play/Pause a Video__

```
_vm.playVideo();
_vm.pauseVideo();
```

- __Exit a video (stop playback)__

```
_vm.exitVideo();
```

- __Seek a Video__

```
_vm.seekTo(90);
```

- __Set Player Vlume__

```
// sets volume to half
_vm.setVolume(0.5);
```

- __Toggle Player Mute__

```
_vm.toggleMute();
```

### Global Functions

- __Open the player__
```
function vm_open() {}

// Open the ViewMedica player with the currently set global variables. Overwrite all information in the current targeted DOM element.

ex.
vm_open();
```

- __Toggle Full Screen Mode__

```
function _vm_toggle_fs(type, target, open) {}

// @param type (string) Unused
// @param target (string) ID of the parent DIV that surrounds the ViewMedica player, which will be given fixed/fullscreen css rules.
// @param open (string) Openthis value for the player FS is being toggled. Used for sizing of the iFrame that contains the ViewMedica player.

ex.
_vm_toggle_fs('fs', '#A_123456', 'A_123456'); //player was opened to an animation
_vm_toggle_fs('fs', '#vm', 'vm'); //default player state
```

- __Add Google Analytics Track__
```
function _vm_ga(trackingcode) {}

// @param trackingcode (string) Information to send to google analytics. The default format used by ViewMedica is #VM Video Title - videofilename - playerlanguage

ex.
_vm_ga('#VM Trigeminal Neuralgia (TN) - trigeminalneur - en'); //adds a track in google analytics
```

### Information Requests

To get started with information requests, you will first have get set up with an API key. Currently, API keys can only be requested via e-mail. This key is used to determine which types of information are allowed access to. There are two basic types of information that can be requested through our API.

1. Client Information
2. Video Information

__Basic Request Example__

Using curl:
```
curl -o viewmedica-video-information.json https://swarminteractive.com/vm/api/video/?key=YOURAPIKEYHERE&description=true
```

Via http:
```
https://swarminteractive.com/vm/api/video/?key=YOURAPIKEYHERE&description=true
Save As >> JSON
```

__Video Information__

Variables are provided below that trigger different types of information to be returned with your API request. You must display copyright information, attached to the response JSON, if this information is displayed on a public website (i.e. © 2012 Swarm Interactive, Inc.). Please refer to your reseller agreement for more information.

- Taxonomy *&taxonomy=L_123456*

Only return video items from a particular taxonomy item, such as a library, collection or group. This value can also be set to false if items should not be grouped.

- Item *&item=filename*
- Item *&item=A_123456*

Get information about a single video item. Openthis codes and filenames are accepted.

- Text *&fulltext=true*

Return video transcript. *Only available through a separate license. Contact us for more info.*

- Description *&description=true*

Get descriptions for video item(s).

- Updated *&updated=true*

Return information about the last updated timestamp.

- Reviewed *&reviewed=true*

Return information about the last reviewed timestamp.

### Client Information

__Create a Client__

You can send an HTTP POST request to ViewMedica servers with your API key to add a new account to your ViewMedica Provider Dashboard. An account created in this fashion will automatically be placed into development mode, so the videos will work for a period of several months with watermarking. You will not be billed until you log in and activate the account.

This function is meant to allow you to send a list of animations that you would like to add to a new account via their unique identifier (aka openthis code, ex. A_123456). It is recommended that you retrieve the available videos via our video information API.

The function will return the created client's JSON information or a 0 if the client creation could not be completed. Let's look at an example request with all of the required pieces:

```
POST URL
https://swarminteractive.com/vm/api/client?key=YOURAPIKEYHERE

REQUIRED PARAMS
username: "yourusername"
password: "yourpassword"
practice: "Your Practice Name"
url: "yoururl.com"
content: "A_b6cd20aa,A_f6094215,A_0c8762d6"
```

As you can see, the content is a comma separated string of all of the animations that the user would like to buy. Our API will automatically calculate the best pricing package for your user based on the number of animations they have chosen, but you can always log in and update it.

You can see example implementations of creating and retrieving clients using CURL in our "examples" folder.

The API will return the exact same response as the Client Information request listed below.

__Get Info About a Client__

Variables are provided below that trigger different types of information to be returned with your API request. Client information will only be available if that account is associated with your API key.

You can see example implementations of creating and retrieving clients using CURL in our "examples" folder.

- Retrieve information about a client. Response includes practice name, url and content list (files/openthis codes).

```
@int client

https://swarminteractive.com/vm/api/client/?key=YOURAPIKEYHERE&client=1234

@return json
```

Example JSON:
```json
{
    id: 1234,
    practice: "Your Practice Name",
    url: "yoururl.com",
    active: 0,
    color: "#364b8c",
    art: "caduceus",
    content: [
        "A_b6cd20aa",
        "A_f6094215",
        "A_0c8762d6",
    ],
    files: [
        "osteomyelitisbeads",
        "conscioussedation",
        "generalanesthesia",
    ]
}
```
