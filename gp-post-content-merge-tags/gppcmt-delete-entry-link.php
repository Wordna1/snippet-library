<?php
/**
 * Gravity Perks // Post Content Merge Tags // Delete Entries Link
 * https://gravitywiz.com/documentation/gravity-forms-post-content-merge-tags/
 *
 * Create a link that will delete an entry when clicked.
 *
 * Video:
 * https://www.loom.com/share/b561a5eaf47942a78f5be06cfc98c879
 *
 * Example of URL:
 * https://local.local/?gppcmt-action=delete&eid={pretty_entry_id}
 *
 * Example w/ Link:
 * <a href="https://local.local/?gppcmt-action=delete&eid={pretty_entry_id}">Delete Entry</a>
 *
 * IMPORTANT! For security, this will only work when passed the entry's Pretty ID generated by GP Post Content Merge Tags
 * and you must update the $allowed_form_ids variable below to enable this for each form from which you wish to delete
 * entries.
 */
add_action( 'init', function() {

	$allowed_form_ids = array( 123 );

	if ( ! isset( $_GET['gppcmt-action'] ) || $_GET['gppcmt-action'] !== 'delete' || ! isset( $_GET['eid'] ) || ! $_GET['eid'] ) {
		return;
	}

	if ( ! is_callable( 'gp_post_content_merge_tags' ) ) {
		return;
	}

	$result = false;
	$entry  = gp_post_content_merge_tags()->get_entry_by_pretty_id( $_GET['eid'] );

	if ( $entry && ! is_wp_error( $entry ) && in_array( $entry['form_id'], $allowed_form_ids ) ) {
		$result = GFAPI::delete_entry( $entry['id'] );
	}

	if ( $result ) {
		echo 'Entry was deleted successfully.';
	} else {
		echo 'There was an error deleting this entry.';
	}

	exit;
} );