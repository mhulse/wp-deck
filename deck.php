<?php

//if ( ! defined('ABSPATH')) exit('No direct script access allowed');

if ( ! function_exists('add_action')) {
	
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
	
}

/**
 * Deck class.
 *
 * A simple way to add a deck (aka subhead) to your posts using the post
 * title field and a specified delimiter.
 *
 * Unaltered example title (no quotes): "First half | Second half".
 * Where "First half" = title & "Second half" = deck.
 *
 * Inspired by WordPress-Subtitle (link below).
 *
 * @author Micky Hulse
 * @copyright Copyright (c) 2013 Micky Hulse
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @package WordPress
 * @version 1.0.0
 * @category Plugin
 * @link http://hulse.me
 * @see http://stackoverflow.com/a/16279114/922323
 * @see http://core.trac.wordpress.org/browser/tags/3.5.1/wp-includes/post-template.php#L118
 * @see http://wordpress.stackexchange.com/questions/45589/
 * @see http://wordpress.stackexchange.com/questions/99039/
 * @see https://github.com/Horttcore/WordPress-Subtitle
 * @see http://wordpress.stackexchange.com/questions/26186
 * @see http://stackoverflow.com/questions/8688738
 */

class Deck
{
	
	public static $delim = '|'; // Feel free to change this.
	
	/**
	 * Constructor.
	 *
	 * @access public
	 * @return void
	 */
	
	function __construct() {
		
		# Hook into `init`:
		add_action('init', array($this, 'init'));
		
	}
	
	//--------------------------------------------------------------------------
	//
	// Public methods:
	//
	//--------------------------------------------------------------------------
	
	/**
	 * Runs after WordPress has finished loading but before any headers are
	 * sent.
	 *
	 * @access public
	 * @return void
	 * @see http://codex.wordpress.org/Plugin_API/Action_Reference/init
	 * @see http://wordpress.stackexchange.com/a/5727/32387
	 * @see http://codex.wordpress.org/Function_Reference/add_filter
	 */
	
	public function init() {
		
		# Only run on the front-end:
		if ( ! is_admin()) {
			
			# Filter `the_title`:
			add_filter('the_title', array($this, 'the_title'), 10, 1); // Is "10" an optimal priority in this case?
			
			# Filter `single_post_title`:
			add_filter('single_post_title', array($this, 'the_title'), 10, 1); // IBID?
			
		}
		
	}
	
	/**
	 * Filter the `post_title`.
	 *
	 * @access public
	 * @param $title { string } The post title.
	 * @return { string } The filterd post title.
	 */
	
	public function the_title($title) {
		
		return self::title_or_deck($title); // Should I use `apply_filters('the_title', ...)` here?
		
	}
	
	//--------------------------------------------------------------------------
	//
	// Static methods:
	//
	//--------------------------------------------------------------------------
	
	/**
	 * Display the deck.
	 *
	 * @access public
	 * @param $post_id { integer } Optional post ID. Default: FALSE.
	 * @return { string } The deck from the post's title.
	 */
	
	static public function the_deck() {
		
		# Use or get the $post_id:
		$post_id = ($post_id) ? $post_id : get_the_ID();
		
		return apply_filters('the_deck', self::$title_or_deck(get_post_field('post_title', $post_id), 'end'));
		
	}
	
	/**
	 * Filter the "deck" from the `post_title`.
	 *
	 * @access public
	 * @param $post_id { integer } Optional post ID. Default: FALSE.
	 * @return { string } The deck from the post's title.
	 */
	
	static public function get_deck($post_id = FALSE) {
		
		# Use or get the $post_id:
		$post_id = ($post_id) ? $post_id : get_the_ID();
		
		return apply_filters('the_deck', self::title_or_deck(get_post_field('post_title', $post_id), 'end'));
		
	}
	
	//--------------------------------------------------------------------------
	//
	// Private methods:
	//
	//--------------------------------------------------------------------------
	
	/**
	 * Return a title or deck from the title field.
	 *
	 * @access private
	 * @param $title { string } The `post_title`.
	 * @param $part { string } One of "current" or "end". Default: 'current'.
	 * @param $delim { string } Delimiter that separates title from deck.
	 * @return { string } Title before or after delimiter.
	 */
	
	static private function title_or_deck($title, $part = 'current') {
		
		# ((if there's no delim) ? (if the deck is requested return an empty string, otherwise return the unaltered title) : return the filtered title or deck)
		return (( ! strpos($title, self::$delim)) ? (($part == 'end') ? '' : $title) : trim($part(explode(self::$delim, $title))));
		
	}
	
}

//--------------------------------------------------------------------------
//
// Instanciate:
//
//--------------------------------------------------------------------------

new Deck();

//--------------------------------------------------------------------------
//
// Helper functions:
//
//--------------------------------------------------------------------------

/**
 * Conditional tag to check for the existence of a deck.
 *
 * @param $post_id { integer } Optional post ID. Default: FALSE.
 * @return { boolean } TRUE if deck exists, otherwise FALSE.
 */

function has_deck($post_id = FALSE) {
	
	if (Deck::get_deck($post_id) !== '') return TRUE;
	
}

/**
 * Display the deck.
 *
 * @param $post_id { integer } Optional post ID. Default: FALSE.
 * @return void
 */

function the_deck($post_id = FALSE) {
	
	echo Deck::get_deck($post_id);
	
}

/**
 * Get the deck.
 *
 * @param $post_id { integer } Optional post ID. Default: FALSE.
 * @return { string } The deck from the post's title.
 */

function get_deck($post_id = FALSE) {
	
	return Deck::get_deck($post_id);
	
}

/* End of file Deck.php */
