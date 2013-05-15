# WordPress Deck

### A simple way to add a deck (aka subhead) to your posts using the post title field and a specified delimiter.

---

#### ABOUT


**Goal:**  
Give bloggers an easy way to add/edit decks when creating/modifying posts via any device.

**Solution**  
Use a custom field or meta box.

**Problem:**  
At this time, WordPress mobile apps have limited options for when it comes to fields they can access (i.e. no custom field or meta box support).

**Solution:**  
Put the deck in the title field separated by a delimter.

**Code:**  
This plugin parses the title field, finds the delimiter and separates the actual title from the desired deck. **Woohoo!**

**Inspiration:**  
See this [discussion here](http://wordpress.stackexchange.com/questions/99039/filtering-the-title-with-option-to-return-subhead).

---

#### USAGE

**NOTE:** So far, I've only tested this code as a ["Must Use" plugin](http://codex.wordpress.org/Must_Use_Plugins), so ...

1. Drop `deck.php` into `wp-content/mu-plugins/`.

1. On the template level:  
	```html
	<header>
		
		<hgroup>
			
			<h1><?=the_title()?></h1>
			
			<?php if (has_deck()): ?>
				
				<h2 class="sh4"><?=get_deck()?></h2>
				
			<?php endif; ?>
			
		</hgroup>
		
	</header>
	```

1. Create a post with a title like:  
	> First half | Second half  

	Where **"First half"** = `title` & **"Second half"** = `deck`.

Feedback? Use [this repo's issue tracker](https://github.com/mhulse/wp-deck/issues). Thanks!

---

#### API

At this time, there is none.

Nor is there an admin interface. I personally like plugins that don't have so much overhead.

If you want to change the delimiter, crack open `deck.php` and change this line:

```php
public static $delim = '|'; // Feel free to change this.
```

Sorry that it's not easier. :(

---

#### LEGAL

Copyright &copy; 2013 [Micky Hulse](http://hulse.me)

Licensed under the Apache License, Version 2.0 (the "License"); you may not use this work except in compliance with the License. You may obtain a copy of the License in the LICENSE file, or at:

[http://www.apache.org/licenses/LICENSE-2.0](http://www.apache.org/licenses/LICENSE-2.0)

Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.
