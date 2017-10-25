backDetect
---

Determining when a user clicks their browser's back button has never been easier with this jQuery plugin.  With a quick easy install and minimal set up work you'll be firing callback functions on back button declarations in no time.  

View a demo of it <a href="http://ianrogren.github.io/jquery-backDetect/">here</a>.

### Installation
---
- Download the latest release from here (or `npm install jquery-backdetect` or `bower install jquery-backdetect`)
- Copy either `jquery.backDetect.js` or `jquery.backDetect.min.js` to your scripts folder
- Include the script after you call on `jQuery`

### Browser Support

| <img src="http://i.imgur.com/dJC1GUv.png" width="48px" height="48px" alt="Chrome logo"> | <img src="http://i.imgur.com/o1m5RcQ.png" width="48px" height="48px" alt="Firefox logo"> | <img src="http://i.imgur.com/8h3iz5H.png" width="48px" height="48px" alt="Internet Explorer logo"> | <img src="http://i.imgur.com/j3tgNKJ.png" width="48px" height="48px" alt="Safari logo"> |
|:---:|:---:|:---:|:---:|:---:|
| All ✔ | All ✔ | 8+ ✔ | All ✔ |

### Basic Usage

Can append to any element or class:

``` html
<script src='backdetect.jquery.js'></script>
<script>
		$(window).load(function(){
			$('body').backDetect(function(){
				// Callback function
			});
		});
</script>
```

### Custom Options

You can set a delay intiate the back detect.  Very similar to setting the time in setTimeout:

``` html
<script src='backdetect.jquery.js'></script>
<script>
		$(window).load(function(){
			$('body').backDetect(function(){
				// Callback function
			});
		}, 1000); // <- 1 second delay
</script>
````

| Settings | Default Value | Description
| --- | --- | --- |
| delay | <pre>delay: 0</pre> |  The length of time it takes for the backDetect plugin to fire and monitor when a user hits the back button. 

### Change Log

1.0.2 Added backDetect to `npm` and `bower` repos.

1.0.1 Removed the need for the 1x1.png image for IE.

### Licence 
``` html
		                    __
		            _,..,_ (, )
		         .,'      `,./
		       .' :`.----.': `,
		      :   : ^    ^ :   ;
		     :   :  6    6  :   ;
		     :   :          :   ;
		     :   :    __    :   ;
< MIT >       :   `:'.--.`:'   ;
		       `.  : o  o :  .'
		        :   `----'   :  
		        : .  :'`:  . :
		        `.:.'    `.:.' 
```


