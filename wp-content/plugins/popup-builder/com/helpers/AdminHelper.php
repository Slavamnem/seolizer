<?php
namespace sgpb;
use \DateTime;
use \DateTimeZone;
use \SgpbDataConfig;

class AdminHelper
{
	/**
	 * Get extension options data which are included inside the free version
	 *
	 * @since 3.0.8
	 *
	 * @return assoc array $extensionOptions
	 */
	public static function getExtensionAvaliabilityOptions()
	{
		$extensionOptions = array();
		// advanced closing option
		$extensionOptions[SGPB_POPUP_ADVANCED_CLOSING_PLUGIN_KEY] = array(
			'sgpb-auto-close',
			'sgpb-enable-popup-overlay',
			'sgpb-disable-popup-closing'
		);
		// schedule extension
		$extensionOptions[SGPB_POPUP_SCHEDULING_EXTENSION_KEY] = array(
			'otherConditionsMetaBoxView'
		);
		// geo targeting extension
		$extensionOptions[SGPB_POPUP_GEO_TARGETING_EXTENSION_KEY] = array(
			'popupConditionsSection'
		);
		// advanced targeting extension
		$extensionOptions[SGPB_POPUP_ADVANCED_TARGETING_EXTENSION_KEY] = array(
			'popupConditionsSection'
		);

 		return $extensionOptions;
	}

	public static function buildCreatePopupUrl($popupType)
	{
		$isAvailable = $popupType->isAvailable();
		$name = $popupType->getName();

		$popupUrl = SG_POPUP_ADMIN_URL.'post-new.php?post_type='.SG_POPUP_POST_TYPE.'&sgpb_type='.$name;

		if (!$isAvailable) {
			$popupUrl = SG_POPUP_PRO_URL;
		}

		return $popupUrl;
	}

	public static function getPopupThumbClass($popupType)
	{
		$isAvailable = $popupType->isAvailable();
		$name = $popupType->getName();

		$popupTypeClassName = $name.'-popup';

		if (!$isAvailable) {
			$popupTypeClassName .= '-pro';
		}

		return $popupTypeClassName;
	}

	public static function getPopupTargetParam($param)
	{
		global $SGPB_DATA_CONFIG_ARRAY;
		$targetData = $SGPB_DATA_CONFIG_ARRAY['target'];

		if (empty($targetData[$param])) {
			return '';
		}

		return $targetData[$param];
	}

	public static function getPopupTargetParamType($param)
	{
		global $SGPB_DATA_CONFIG_ARRAY;
		$targetDataTypes = $SGPB_DATA_CONFIG_ARRAY['target']['types'];

		if (empty($targetDataTypes[$param])) {
			return '';
		}

		return $targetDataTypes[$param];
	}

	public static function createSelectBox($data, $selectedValue, $attrs)
	{
		$attrString = '';
		$selected = '';
		$selectBoxCloseTag = '</select>';

		if (!empty($attrs) && isset($attrs)) {

			foreach ($attrs as $attrName => $attrValue) {
				$attrString .= ''.$attrName.'="'.$attrValue.'" ';
			}
		}

		$selectBox = '<select '.$attrString.'>';

		if (empty($data)) {
			$selectBox .= $selectBoxCloseTag;
			return $selectBox;
		}
		foreach ($data as $value => $label) {
			// When is multiSelect
			if (is_array($selectedValue)) {
				$isSelected = in_array($value, $selectedValue);
				if ($isSelected) {
					$selected = 'selected';
				}
			}
			else if ($selectedValue == $value) {
				$selected = 'selected';
			}
			else if (is_array($value) && in_array($selectedValue, $value)) {
				$selected = 'selected';
			}

			if (is_array($label)) {
				$selectBox .= '<optgroup label="'.$value.'">';
					foreach ($label as $key => $optionLabel) {
						$selected = '';
						if (is_array($selectedValue)) {
							$isSelected = in_array($key, $selectedValue);
							if ($isSelected) {
								$selected = 'selected';
							}
						}
						else if ($selectedValue == $key) {
							$selected = 'selected';
						}
						else if (is_array($key) && in_array($selectedValue, $key)) {
							$selected = 'selected';
						}

						$selectBox .= '<option value="'.$key.'" '.$selected.'>'.$optionLabel.'</option>';
					}
				$selectBox .= '</optgroup>';
			}
			else {
				$selectBox .= '<option value="'.$value.'" '.$selected.'>'.$label.'</option>';
			}

			$selected = '';
		}

		$selectBox .= $selectBoxCloseTag;

		return $selectBox;
	}

	public static function createInput($data, $selectedValue, $attrs)
	{
		$attrString = '';
		$savedData = $data;

		if (isset($selectedValue)) {
			$savedData = $selectedValue;
		}
		if (!empty($attrs) && isset($attrs)) {

			foreach ($attrs as $attrName => $attrValue) {
				if ($attrName == 'class') {
					$attrValue .= ' sgpb-full-width-events form-control';
				}
				$attrString .= ''.$attrName.'="'.$attrValue.'" ';
			}
		}
		$input = "<input $attrString value=\"".esc_attr($savedData)."\">";

		return $input;
	}

	public static function createCheckBox($data, $selectedValue, $attrs)
	{
		$attrString = '';
		$checked = '';

		if (!empty($selectedValue)) {
			$checked = 'checked';
		}
		if (!empty($attrs) && isset($attrs)) {

			foreach ($attrs as $attrName => $attrValue) {
				$attrString .= ''.$attrName.'="'.$attrValue.'" ';
			}
		}

		$input = "<input $attrString $checked>";

		return $input;
	}

	public static function createRadioButtons($elements, $name, $selectedInput, $lineMode = false)
	{
		$str = '';

		foreach ($elements as $key => $element) {;
			$value = '';
			$checked = '';

			if (isset($element['value'])) {
				$value = $element['value'];
			}
			if ($element['value'] == $selectedInput) {
				$checked = 'checked';
			}
			$attrStr = '';
			if (isset($element['data-attributes'])) {
				foreach ($element['data-attributes'] as $attrKey => $dataValue) {
					$attrStr .= $attrKey.'="'.esc_attr($dataValue).'" ';
				}
			}

			if ($lineMode) {
				$str .= '<input type="radio" name="'.esc_attr($name).'" value="'.esc_attr($value).'" '.$checked.' '.$attrStr.'>';
			}
			else {
				$str .= '<div class="row form-group">';
					$str .= '<label class="col-md-5 control-label">'.__($element['title'], SG_POPUP_TEXT_DOMAIN).'</label>';
					$str .= '<div class="col-sm-7"><input type="radio" name="'.esc_attr($name).'" value="'.esc_attr($value).'" '.$checked.'></div>';
				$str .= '</div>';
			}
		}

		echo $str;
	}

	// countdown popup (number) styles
	public static function renderCountdownStyles($popupId = 0, $countdownBgColor, $countdownTextColor)
	{
		return  "<style type='text/css'>
			.sgpb-counts-content.sgpb-flipclock-js-$popupId.flip-clock-wrapper ul li a div div.inn {
				background-color: $countdownBgColor;
				color: $countdownTextColor;
			}
			.sgpb-countdown-wrapper {
				width: 446px;
				height: 130px;
				padding-top: 22px;
				box-sizing: border-box;
				margin: 0 auto;
			}
			.sgpb-counts-content {
				display: inline-block;
			}
			.sgpb-counts-content > ul.flip {
				width: 40px;
				margin: 4px;
			}
		</style>";
	}

	// countdown popup scripts and params
	public static function renderCountdownScript($id, $seconds, $type, $language, $timezone, $autoclose)
	{
		$params = array(
			'id'        => $id,
			'seconds'   => $seconds,
			'type'      => $type,
			'language'  => $language,
			'timezone'  => $timezone,
			'autoclose' => $autoclose
		);

		return $params;
	}

	public static function getDateObjFromDate($dueDate, $timezone = 'America/Los_Angeles', $format = 'Y-m-d H:i:s')
	{
		$dateObj = new DateTime($dueDate, new DateTimeZone($timezone));
		$dateObj->format($format);

		return $dateObj;
	}

	// convert date to seconds
	public static function dateToSeconds($dueDate, $timezone)
	{
		if (empty($timezone)) {
			return '';
		}

		$dateObj = self::getDateObjFromDate('now', $timezone);
		$timeNow = @strtotime($dateObj);
		$seconds = @strtotime($dueDate)-$timeNow;
		if ($seconds < 0) {
			$seconds = 0;
		}

		return $seconds;
	}

	/**
	 * Serialize data
	 *
	 * @since 1.0.0
	 *
	 * @param array $data
	 *
	 * @return string $serializedData
	 */
	public static function serializeData($data = array())
	{
		$serializedData = serialize($data);

		return $serializedData;
	}

	/**
	 * Get correct size to use it safely inside CSS rules
	 *
	 * @since 1.0.0
	 *
	 * @param string $dimension
	 *
	 * @return string $size
	 */
	public static function getCSSSafeSize($dimension)
	{
		if (empty($dimension)) {
			return 'inherit';
		}

		$size = (int)$dimension . 'px';
		// If user write dimension in px or % we give that dimension to target otherwise the default value will be px
		if (strpos($dimension, '%') || strpos($dimension, 'px')) {
			$size = $dimension;
		}

		return $size;
	}

	/**
	 * Get site protocol
	 *
	 * @since 1.0.0
	 *
	 * @return string $protocol
	 *
	 */
	public static function getSiteProtocol()
	{
		$protocol = 'http';

		if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
			$protocol = 'https';
		}

		return $protocol;
	}

	public static function getCurrentUrl()
	{
		$protocol = self::getSiteProtocol();
		$currentUrl = $protocol."://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

		return $currentUrl;
	}

	public static function deleteSubscriptionPopupSubscribers($popupId)
	{
		global $wpdb;

		$prepareSql = $wpdb->prepare('DELETE FROM '.$wpdb->prefix.SGPB_SUBSCRIBERS_TABLE_NAME.' WHERE subscriptionType = %s', $popupId);
		$wpdb->query($prepareSql);
	}

	public static function subscribersRelatedQuery($query = '')
	{
		global $wpdb;
		$subscribersTablename = $wpdb->prefix.SGPB_SUBSCRIBERS_TABLE_NAME;
		$postsTablename = $wpdb->prefix.SGPB_POSTS_TABLE_NAME;

		if ($query == '') {
			$query = 'SELECT firstName, lastName, email, cDate, '.$postsTablename.'.post_title AS subscriptionType FROM '.$subscribersTablename.' ';
		}
		$searchQuery = ' unsubscribed <> 1';
		$filterCriteria = '';

		$query .= ' LEFT JOIN '.$postsTablename.' ON '.$postsTablename.'.ID='.$subscribersTablename.'.subscriptionType';

		if (isset($_GET['sgpb-subscription-popup-id']) && !empty($_GET['sgpb-subscription-popup-id'])) {
			$filterCriteria = esc_sql($_GET['sgpb-subscription-popup-id']);
			if ($filterCriteria != 'all') {
				$searchQuery .= "(subscriptionType = $filterCriteria)";
			}
		}
		if ($filterCriteria != '' && $filterCriteria != 'all' && isset($_GET['s']) && !empty($_GET['s'])) {
			$searchQuery .= ' AND ';
		}
		if (isset($_GET['s']) && !empty($_GET['s'])) {
			$searchCriteria = esc_sql($_GET['s']);
			$searchQuery .= " (firstName LIKE '%$searchCriteria%' or lastName LIKE '%$searchCriteria%' or email LIKE '%$searchCriteria%' or $postsTablename.post_title LIKE '%$searchCriteria%')";
		}
		if (isset($_GET['sgpb-subscribers-date']) && !empty($_GET['sgpb-subscribers-date'])) {
			$filterCriteria = esc_sql($_GET['sgpb-subscribers-date']);
			if ($filterCriteria != 'all') {
				if ($searchQuery != '') {
					$searchQuery .= ' AND ';
				}
				$searchQuery .= " cDate LIKE '$filterCriteria%'";
			}
		}
		if ($searchQuery != '') {
			$query .= " WHERE $searchQuery";
		}

		return $query;
	}

	public static function themeRelatedSettings($popupId, $buttonPosition, $theme)
	{
		if ($popupId) {
			if ($theme == 'sgpb-theme-1' || $theme == 'sgpb-theme-4' || $theme == 'sgpb-theme-5') {
				if (isset($buttonPosition)) {
					$buttonPosition = $buttonPosition;
				}
				else {
					$buttonPosition = 'bottomRight';
				}
			}
			else if ($theme == 'sgpb-theme-2' || $theme == 'sgpb-theme-3' || $theme == 'sgpb-theme-6') {
				if (isset($buttonPosition)) {
					$buttonPosition = $buttonPosition;
				}
				else {
					$buttonPosition = 'topRight';
				}
			}
		}
		else {
			if (isset($theme)) {
				if ($theme == 'sgpb-theme-1' || $theme == 'sgpb-theme-4' || $theme == 'sgpb-theme-5') {
					$buttonPosition = 'bottomRight';
				}
				else if ($theme == 'sgpb-theme-2' || $theme == 'sgpb-theme-3' || $theme == 'sgpb-theme-6') {
					$buttonPosition = 'topRight';
				}
			}
			else {
				/* by default set position for the first theme */
				$buttonPosition = 'bottomRight';
			}
		}

		return $buttonPosition;
	}

	/**
	 * Create html attrs
	 *
	 * @since 1.0.0
	 *
	 * @param array $attrs
	 *
	 * @return string $attrStr
	 */
	public static function createAttrs($attrs)
	{
		$attrStr = '';

		if (empty($attrs)) {
			return $attrStr;
		}

		foreach ($attrs as $attrKey => $attrValue) {
			$attrStr .= $attrKey.'="'.$attrValue.'" ';
		}

		return $attrStr;
	}

	public static function getFormattedDate($date)
	{
		$date = strtotime($date);
		$month = date('F', $date);
		$year = date('Y', $date);

		return $month.' '.$year;
	}

	public static function defaultButtonImage($theme, $closeImage = '')
	{
		$currentPostType = self::getCurrentPopupType();
		if (defined('SGPB_POPUP_TYPE_RECENT_SALES') && $currentPostType == SGPB_POPUP_TYPE_RECENT_SALES) {
			$theme = 'sgpb-theme-6';
		}
		// if no image, set default by theme
		if ($closeImage == '') {
			if ($theme == 'sgpb-theme-1' || !$theme) {
				$closeImage = 'iVBORw0KGgoAAAANSUhEUgAAABUAAAAVCAYAAACpF6WWAAADHElEQVQ4jaWVQU8bRxiGHxYHrwdbHW8gFhU5IKurWM0plTiQC1SqUFD6C7hEorfmSv9ChBC39NZDFCm3xrkl6gWoKjBCizgRoS0uh0Y1BjQ7ks3sGkK2B2MLY4dE7Xvd93v0zXzfvNsXxzG9VKlUprXWk8aYceAOkAOqwK4QYlNKuToyMvJbr9q+q1Ct9bflcvkRMCuEsNKZDIn+/vb39+fn1Gs1jDEfgBf5fP6ZlHL5o9D9/f0flFLzQgjXGf4SkRrgRn8ftm23PVEUcXYeY8JT1NE/GGN8x3EWx8bGfml5EleAT27lckOZdBopv+h5LbZtYwOZwRTJREytXncPq9UnAC1wonVkpdT8rVxuSGZvkhlM9QRelZSS/htJgKHDanU+m83+JaVctgDK5fIjIYSbSac/G9hSZjBFJp1GCOFezIJEpVKZBmallEgp2+a/373jT98H4CvX5fboKABr6+s0ooikbXN/YqLdcRiGGGNmK5XKC0trPSmEsFKpzg5l9iZ7e3uUSiXevH5N7SRkbX2d1ZUVSqUSTjbb4b+ot7TWk5YxZjydyXRMuHWsBzMzABwdHfHH7yusr60BUCgUKBQKHX7btnEcB2PMuEVzsXvq9ugok1NTAGxvb3N6esrw8DDfTT/o8l5q6o5F86V0ddrSN/fuMTAwQL1eZ2dnh6/v3v3UMHMWUH1/dvZRR7H4io2NDXzfp9Fo8PPTp2itr4NWLWAXmi/lqra2tnj58lcA5ubmSCaTNBoNFhYWuryX6nctIcSmUqoLqrVmaWkJANd1mZmZ4cfHjwHwfZ9isdgFVUohhNhMSClXjTE/hWFoXd7TnbdvefjwewCmpiYBuD8xQfXggChqEEWNDmgYhgAfpJSrxHGM53nPPc+LgyCI/4uCIIg9z4s9z3sexzEWQD6ffwb4QRBQOwmvG0KXaichQRAA+BecJlRKuew4zqJS6vj48OBT021La83x4QFKqWPHcRZbudqOvlZsKaXmoyhywzAklUo1o+5KnkZRRBiGaK175um1yQ9YjuMAzcfR2hClFMDnJf9l/Z9/1L81r78oUzK1YgAAAABJRU5ErkJggg==';
			}
			else if ($theme == 'sgpb-theme-2') {
				$closeImage = 'iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAAXNSR0IArs4c6QAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAABWWlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS40LjAiPgogICA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgogICAgICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgICAgICAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyI+CiAgICAgICAgIDx0aWZmOk9yaWVudGF0aW9uPjE8L3RpZmY6T3JpZW50YXRpb24+CiAgICAgIDwvcmRmOkRlc2NyaXB0aW9uPgogICA8L3JkZjpSREY+CjwveDp4bXBtZXRhPgpMwidZAAABWUlEQVQ4Ee2SS46CQBCGf8gAcgHFG+jGtfEWXIBHOBcKR+EScAQfG90RSGCGvyY9MtIuTFzMYippuqur6qO6qozPQfBGMd/IEtQ/8F7R2+0GLorqm9qv16vYlH6PAj7Gijqfz2fs93sYhoEwDLFcLsVE/XQ6Icsy0eM4xmKxUGGya5tSVRWappHFYEIoCkZb27Yoy1Luxx8tcLVaYTabSYYMJrQoCtmpU2zbxnq9HrPkbAx1mAw2ry6XC9I0Rdd16Pv+23l4Ms/8WRRF8DxvAtRmyFrN53MkSQLLsn41hbZnMNK1QBoYyEy5THPqpnkYw54Dj8cj8jyX4vOZYwBryknQyfTXgxedCavrWmJc14Xv+3AcR3Q25nA4/HR/DNYC1djw2YQEQYDNZiO1U1CODf0eRQvcbrfSFNVNDjbh7CobQigHerfbPfKgHZuJ1wsX2gxfiJ+4/n3gF7OOrAbt6WEPAAAAAElFTkSuQmCC';
			}
			else if ($theme == 'sgpb-theme-3') {
				$closeImage = 'iVBORw0KGgoAAAANSUhEUgAAACcAAAAUCAMAAAA5k9QEAAAAllBMVEVHcEwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAC0tbUhISHFxcYICAitr7EqKipKSkrMzMzHyMqIiouQkZO9vb0QEBB7e3tDRESlpaapq61qamvBw8Tk5ebe3t/R0tMZGRo6Ojp/gIGgoqRSUlLq6uuZmZnW1te3ubt2d3hf8fIfAAAAEXRSTlMAzFVEMRFmd7vumd2qbCKID4nBdwUAAADPSURBVCjPhdLXEoIwFATQBSIIVkKxACrdXv7/50RCDQj7krk7hwyTBERa6KNZEIDIwhjTxDV+EdUhJRCUIQNQmKCOVNVntmzKedZkwLyoj1Eu3Me9KOQWg8haw9yZGXTjmLJCBZfi8+0+g06S0AOb57wTapimL7tgusK7qV7B/a7cbch9vMg0t6MupO+n7XmnERcGtmsZAaWnQWfcfMfKFt92eo8PUFh/uVq5P1psXvJu0nvFU+DPhu2QroPWZTL6suKUKqI/ktb4yZnSfFFfkB8jKwCptUAAAAAASUVORK5CYII=';
			}
			else if ($theme == 'sgpb-theme-5') {
				$closeImage = 'iVBORw0KGgoAAAANSUhEUgAAABEAAAARCAYAAAA7bUf6AAAAAXNSR0IArs4c6QAAAVlpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IlhNUCBDb3JlIDUuNC4wIj4KICAgPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICAgICAgPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIKICAgICAgICAgICAgeG1sbnM6dGlmZj0iaHR0cDovL25zLmFkb2JlLmNvbS90aWZmLzEuMC8iPgogICAgICAgICA8dGlmZjpPcmllbnRhdGlvbj4xPC90aWZmOk9yaWVudGF0aW9uPgogICAgICA8L3JkZjpEZXNjcmlwdGlvbj4KICAgPC9yZGY6UkRGPgo8L3g6eG1wbWV0YT4KTMInWQAAAVRJREFUOBGtVDuugzAQXBwhIA1UUKWgoOMAnIETcJwchxNwEgokSiqQUtAEEL/HWNongwJ6T8oWxti7w+CZtfZ6vdZ5nilNU2rblpIkIdd1qXu/aVkW4hBCkHW/U9M0MjcIAorjmMZxJMEA2ByGQSZgjgIUIo4AyMvznLIsI13X6fZ4PJ4o4gBoURTk+z45jkPrxsa0rF8GAOBAHdgLDMdQGZ0BcE1ZlqRtw4rzUL/ACYZhyPOpqoqXdk/s4wy1jckKWmdAuyrlhQEggoAKmAARG38JFQD1AjL+B+gIgHqpISZD35PneZLVFRv4A3nIZx9JEPjAME2q61pKeQUCNZCHfMVHeyd+UkkFVeVnQ35HnSt5cYiboz+qpjK6bfI+P/0CqxBFkWwBtAJaQg1uEWHbtrou5wwA//Rdd+kjqCW49RlJBYB/pmk69VEYhvI60L5xn/wAjtgb/fA0ZZYAAAAASUVORK5CYII=';
			}
			else if ($theme == 'sgpb-theme-6') {
				$closeImage = 'iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAACXBIWXMAAAsTAAALEwEAmpwYAAA6HWlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS42LWMxMzggNzkuMTU5ODI0LCAyMDE2LzA5LzE0LTAxOjA5OjAxICAgICAgICAiPgogICA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgogICAgICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgICAgICAgICB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iCiAgICAgICAgICAgIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIKICAgICAgICAgICAgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIgogICAgICAgICAgICB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIKICAgICAgICAgICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgICAgICAgICAgeG1sbnM6dGlmZj0iaHR0cDovL25zLmFkb2JlLmNvbS90aWZmLzEuMC8iCiAgICAgICAgICAgIHhtbG5zOmV4aWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20vZXhpZi8xLjAvIj4KICAgICAgICAgPHhtcDpDcmVhdGVEYXRlPjIwMTgtMDItMjdUMTQ6MTQ6MzgrMDQ6MDA8L3htcDpDcmVhdGVEYXRlPgogICAgICAgICA8eG1wOk1vZGlmeURhdGU+MjAxOC0wMi0yN1QxNDoxNjoxMSswNDowMDwveG1wOk1vZGlmeURhdGU+CiAgICAgICAgIDx4bXA6TWV0YWRhdGFEYXRlPjIwMTgtMDItMjdUMTQ6MTY6MTErMDQ6MDA8L3htcDpNZXRhZGF0YURhdGU+CiAgICAgICAgIDx4bXA6Q3JlYXRvclRvb2w+QWRvYmUgUGhvdG9zaG9wIENDIDIwMTcgKFdpbmRvd3MpPC94bXA6Q3JlYXRvclRvb2w+CiAgICAgICAgIDxkYzpmb3JtYXQ+aW1hZ2UvcG5nPC9kYzpmb3JtYXQ+CiAgICAgICAgIDxwaG90b3Nob3A6Q29sb3JNb2RlPjM8L3Bob3Rvc2hvcDpDb2xvck1vZGU+CiAgICAgICAgIDx4bXBNTTpJbnN0YW5jZUlEPnhtcC5paWQ6MWNlZWE3YWMtNTIxMC02MjQ2LWFiMDQtZTA1YmEwYjljOTQ1PC94bXBNTTpJbnN0YW5jZUlEPgogICAgICAgICA8eG1wTU06RG9jdW1lbnRJRD5hZG9iZTpkb2NpZDpwaG90b3Nob3A6MzFlZDk3OGEtMWJhNy0xMWU4LTg0YTctZjA4OTdlNjEzNGM0PC94bXBNTTpEb2N1bWVudElEPgogICAgICAgICA8eG1wTU06T3JpZ2luYWxEb2N1bWVudElEPnhtcC5kaWQ6OWFmYzkxOTgtOWNlNC1lZDQ4LThlNjYtNmFkMzdiNGFmOTQxPC94bXBNTTpPcmlnaW5hbERvY3VtZW50SUQ+CiAgICAgICAgIDx4bXBNTTpIaXN0b3J5PgogICAgICAgICAgICA8cmRmOlNlcT4KICAgICAgICAgICAgICAgPHJkZjpsaSByZGY6cGFyc2VUeXBlPSJSZXNvdXJjZSI+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDphY3Rpb24+c2F2ZWQ8L3N0RXZ0OmFjdGlvbj4KICAgICAgICAgICAgICAgICAgPHN0RXZ0Omluc3RhbmNlSUQ+eG1wLmlpZDo5YWZjOTE5OC05Y2U0LWVkNDgtOGU2Ni02YWQzN2I0YWY5NDE8L3N0RXZ0Omluc3RhbmNlSUQ+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDp3aGVuPjIwMTgtMDItMjdUMTQ6MTY6MTErMDQ6MDA8L3N0RXZ0OndoZW4+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDpzb2Z0d2FyZUFnZW50PkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE3IChXaW5kb3dzKTwvc3RFdnQ6c29mdHdhcmVBZ2VudD4KICAgICAgICAgICAgICAgICAgPHN0RXZ0OmNoYW5nZWQ+Lzwvc3RFdnQ6Y2hhbmdlZD4KICAgICAgICAgICAgICAgPC9yZGY6bGk+CiAgICAgICAgICAgICAgIDxyZGY6bGkgcmRmOnBhcnNlVHlwZT0iUmVzb3VyY2UiPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6YWN0aW9uPnNhdmVkPC9zdEV2dDphY3Rpb24+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDppbnN0YW5jZUlEPnhtcC5paWQ6MWNlZWE3YWMtNTIxMC02MjQ2LWFiMDQtZTA1YmEwYjljOTQ1PC9zdEV2dDppbnN0YW5jZUlEPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6d2hlbj4yMDE4LTAyLTI3VDE0OjE2OjExKzA0OjAwPC9zdEV2dDp3aGVuPgogICAgICAgICAgICAgICAgICA8c3RFdnQ6c29mdHdhcmVBZ2VudD5BZG9iZSBQaG90b3Nob3AgQ0MgMjAxNyAoV2luZG93cyk8L3N0RXZ0OnNvZnR3YXJlQWdlbnQ+CiAgICAgICAgICAgICAgICAgIDxzdEV2dDpjaGFuZ2VkPi88L3N0RXZ0OmNoYW5nZWQ+CiAgICAgICAgICAgICAgIDwvcmRmOmxpPgogICAgICAgICAgICA8L3JkZjpTZXE+CiAgICAgICAgIDwveG1wTU06SGlzdG9yeT4KICAgICAgICAgPHRpZmY6T3JpZW50YXRpb24+MTwvdGlmZjpPcmllbnRhdGlvbj4KICAgICAgICAgPHRpZmY6WFJlc29sdXRpb24+NzIwMDAwLzEwMDAwPC90aWZmOlhSZXNvbHV0aW9uPgogICAgICAgICA8dGlmZjpZUmVzb2x1dGlvbj43MjAwMDAvMTAwMDA8L3RpZmY6WVJlc29sdXRpb24+CiAgICAgICAgIDx0aWZmOlJlc29sdXRpb25Vbml0PjI8L3RpZmY6UmVzb2x1dGlvblVuaXQ+CiAgICAgICAgIDxleGlmOkNvbG9yU3BhY2U+NjU1MzU8L2V4aWY6Q29sb3JTcGFjZT4KICAgICAgICAgPGV4aWY6UGl4ZWxYRGltZW5zaW9uPjMwPC9leGlmOlBpeGVsWERpbWVuc2lvbj4KICAgICAgICAgPGV4aWY6UGl4ZWxZRGltZW5zaW9uPjMwPC9leGlmOlBpeGVsWURpbWVuc2lvbj4KICAgICAgPC9yZGY6RGVzY3JpcHRpb24+CiAgIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+CiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgCiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAKICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIAogICAgICAgICAgICAgICAgICAgICAgICAgICAgCjw/eHBhY2tldCBlbmQ9InciPz7HmtNXAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAjWSURBVHjanFd9bFPXFf/d9/zsZ/v5ObZfAnbIUpI0fCxMhGlJkxaNKpFAKkqntUIIaYRJJR9FiEGoJqoOov1RMVE1UxvSsoIqbVJVCoJuomVlypYh8aERWEoZ6dwSlYJxkmcndj7s5/d19k9s4TZM64509a7ufff+zjn3nHN/l+HRwhhjICIAIAAIBoNuv9/v1XVdBCAA4Fwul+F2u/XZ2VnNNM2ZiYkJ27Is/F/CGGMcxzHGGHM6nS5FUb5XWVnZuHPnzhey2ewJIjpPRKNEdJeI/kVEf83lcr+bn5//6c6dO6uXL1/u5TjuO2MyQRB4nuedHo9naWtra9ulS5fO0oJkMhlSVZXi8TjFYjGKx+Okqipls9n8Lyki+k1XV9fampqaPDr7FtA3+zzPcwAckUjk+z09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';
			}
		}
		else {
			$closeImage = self::getImageDataFromUrl($closeImage);
		}

		return $closeImage;
	}

	public static function getPopupPostAllowedUserRoles()
	{
		$userSavedRoles = get_option('sgpb-user-roles');

		if (empty($userSavedRoles) || !is_array($userSavedRoles)) {
			$userSavedRoles = array('administrator');
		}
		else {
			array_push($userSavedRoles, 'administrator');
		}

		return $userSavedRoles;
	}

	public static function showMenuForCurrentUser()
	{
		$savedUserRoles = self::getPopupPostAllowedUserRoles();
		$currentUserRole = self::getCurrentUserRole();
		if (!is_array($savedUserRoles) || !is_array($currentUserRole)) {
			return true;
		}

		return array_intersect($currentUserRole, $savedUserRoles);
	}

	public static function getPopupsIdAndTitle($excludesPopups = array())
	{
		$allPopups = SGPopup::getAllPopups();
		$popupIdTitles = array();

		if (empty($allPopups)) {
			return $popupIdTitles;
		}

		foreach ($allPopups as $popup) {
			if (empty($popup)) {
				continue;
			}

			$id = $popup->getId();
			$title = $popup->getTitle();
			$type = $popup->getType();

			if (!empty($excludesPopups)) {
				foreach ($excludesPopups as $excludesPopupId) {
					if ($excludesPopupId != $id) {
						$popupIdTitles[$id] = $title . ' - ' . $type;
					}
				}
			}
			else {
				$popupIdTitles[$id] = $title . ' - ' . $type;
			}
		}

		return $popupIdTitles;
	}

	/**
	 * Merge two array and merge same key values to same array
	 *
	 * @since 1.0.0
	 *
	 * @param array $array1
	 * @param array $array2
	 *
	 * @return array|bool
	 *
	 */
	public static function arrayMergeSameKeys($array1, $array2)
	{
		if (empty($array1)) {
			return array();
		}

		$modified = false;
		$array3 = array();
		foreach ($array1 as $key => $value) {
			if (isset($array2[$key]) && is_array($array2[$key])) {
				$arrDifference = array_diff($array2[$key], $array1[$key]);
				if (empty($arrDifference)) {
					continue;
				}

				$modified = true;
				$array3[$key] = array_merge($array2[$key], $array1[$key]);
				unset($array2[$key]);
				continue;
			}

			$modified = true;
			$array3[$key] = $value;
		}

		// when there are no values
		if (!$modified) {
			return $modified;
		}

		return $array2 + $array3;
	}

	public static function getCurrentUserRole()
	{
		$role = array('administrator');

		if (is_multisite()) {

			$getUsersObj = get_users(
				array(
					'blog_id' => get_current_blog_id()
				)
			);
			if (is_array($getUsersObj)) {
				foreach ($getUsersObj as $key => $userData) {
					if ($userData->ID == get_current_user_id()) {
						$roles = $userData->roles;
						if (is_array($roles) && !empty($roles)) {
							$role[] = $roles[0];
						}
					}
				}
			}

			return $role;
		}

		global $current_user;
		$userRoleName = $current_user->roles;

		if (!empty($userRoleName)) {
			$role = $userRoleName;
		}

		return $role;
	}

	public static function isAppleMobileDevice()
	{
		$isIOS = false;

		$useragent = @$_SERVER['HTTP_USER_AGENT'];
		preg_match('/iPhone|Android|iPad|iPod|webOS/', $useragent, $matches);
		$os = current($matches);
		if ($os == 'iPad' || $os == 'iPhone' || $os == 'iPod') {
			$isIOS = true;
		}

		return $isIOS;
	}

	public static function hexToRgba($color, $opacity = false)
	{
		$default = 'rgb(0,0,0)';

		//Return default if no color provided
		if (empty($color)) {
			return $default;
		}

		//Sanitize $color if "#" is provided
		if ($color[0] == '#') {
			$color = substr($color, 1);
		}

		//Check if color has 6 or 3 characters and get values
		if (strlen($color) == 6) {
			$hex = array($color[0].$color[1], $color[2].$color[3], $color[4].$color[5]);
		}
		else if (strlen($color) == 3) {
			$hex = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
		}
		else {
			return $default;
		}

		//Convert hexadec to rgb
		$rgb = array_map('hexdec', $hex);

		//Check if opacity is set(rgba or rgb)
		if ($opacity !== false) {
			if (abs($opacity) > 1) {
				$opacity = 1.0;
			}
			$output = 'rgba('.implode(',', $rgb).','.$opacity.')';
		}
		else {
			$output = 'rgb('.implode(',', $rgb).')';
		}

		//Return rgb(a) color string
		return $output;
	}

	public static function getAllActiveExtensions()
	{
		$extensions = SgpbDataConfig::getOldExtensionsInfo();
		$labels = array();

		foreach ($extensions as $extension) {
			if (file_exists(WP_PLUGIN_DIR.'/'.$extension['folderName'])) {
				$labels[] = $extension['label'];
			}
		}

		return $labels;
	}

	public static function renderExtensionsContent()
	{
		$extensions = self::getAllActiveExtensions();
		ob_start();
		?>
			<p class="sgpb-extension-notice-close">x</p>
			<div class="sgpb-extensions-list-wrapper">
				<div class="sgpb-notice-header">
					<h3><?php _e('Popup Builder plugin has been successfully updated', SG_POPUP_TEXT_DOMAIN)?></h3>
					<h4><?php _e('The following extensions need to be updated manually', SG_POPUP_TEXT_DOMAIN)?></h4>
				</div>
				<ul class="sgpb-extensions-list">
					<?php foreach ($extensions as $extensionName): ?>
						<a target="_blank" href="https://popup-builder.com/forms/control-panel/"><li><?php echo $extensionName; ?></li></a>
					<?php endforeach; ?>
				</ul>
			</div>
			<p class="sgpb-extension-notice-dont-show"><?php _e('Don\'t show again')?></p>
		<?php
		$content = ob_get_contents();
		ob_get_clean();

		return $content;
	}

	public static function getReverseConvertIds()
	{
		$idsMappingSaved = get_option('sgpbConvertedIds');
		$ids = array();

		if ($idsMappingSaved) {
			$ids = $idsMappingSaved;
		}

		return array_flip($ids);
	}

	public static function getAllExtensions()
	{
		$allExtensions = SgpbDataConfig::allExtensionsKeys();

		$notActiveExtensions = array();
		$activeExtensions = array();

		foreach ($allExtensions as $extension) {
			if (!is_plugin_active($extension['pluginKey'])) {
				$notActiveExtensions[] = $extension;
			}
			else {
				$activeExtensions[] = $extension;
			}
		}

		$divideExtension = array(
			'noActive' => $notActiveExtensions,
			'active' => $activeExtensions
		);

		return $divideExtension;
	}

	public static function renderAlertProblem()
	{
		ob_start();
		?>
		<div id="welcome-panel" class="update-nag sgpb-alert-problem">
			<div class="welcome-panel-content">
				<p class="sgpb-problem-notice-close">x</p>
				<div class="sgpb-alert-problem-text-wrapper">
					<h3>Popup Builder plugin has been updated to the new version 3.</h3>
					<h5>A lot of changes and improvements have been made.</h5>
					<h5>In case of any issues, please contact us <a href="<?php echo SG_POPUP_TICKET_URL; ?>" target="_blank">here</a>.</h5>
				</div>
				<p class="sgpb-problem-notice-dont-show"><?php _e('Don\'t show again')?></p>
			</div>
		</div>
		<?php
		$content = ob_get_clean();

		return $content;
	}

	public static function getTaxonomyBySlug($slug = '')
	{
		$allTerms = get_terms(array('hide_empty' => false));

		$result = array();
		if (empty($allTerms)) {
			return $result;
		}
		if ($slug == '') {
			return $allTerms;
		}
		foreach ($allTerms as $term) {
			if ($term->slug == $slug) {
				return $term;
			}
		}
	}

	// proStartSilver
	public static function setPushToBottom($element = '')
	{
		$style = '<style type="text/css">';
		$style .= "$element";
		$style .= '{position: absolute !important;';
		$style .= 'left: 0 !important;';
		$style .= 'right: 0 !important;';
		$style .= 'bottom: 2px !important;}';
		$style .= '</style>';

		return $style;
	}
	// proEndSilver

	public static function getCurrentPopupType()
	{
		$type = '';
		if (!empty($_GET['sgpb_type'])) {
			$type  = $_GET['sgpb_type'];
		}

		$currentPostType = self::getCurrentPostType();

		if ($currentPostType == SG_POPUP_POST_TYPE && !empty($_GET['post'])) {
			$popupObj = SGPopup::find($_GET['post']);
			if (is_object($popupObj)) {
				$type = $popupObj->getType();
			}
		}

		return $type;
	}

	public static function getCurrentPostType()
	{
		global $post_type;
		global $post;

		$currentPostType = @$post->post_type;
		// in some themes global $post returns null
		if (empty($currentPostType)) {
			$currentPostType = $post_type;
		}

		return $currentPostType;
	}


	/**
	 * Get image encoded data from URL
	 *
	 * @param $imageUrl
	 *
	 * @return string
	 */
	public static function getImageDataFromUrl($imageUrl)
	{
		$data = '';
		$remoteData = wp_remote_get($imageUrl);

		if (is_wp_error($remoteData)) {
			return $data;
		}

		$imageData = wp_remote_retrieve_body($remoteData);

		return base64_encode($imageData);
	}

	public static function deleteUserFromSubscribers($params = array())
	{
		global $wpdb;

		$token = '';
		$email = '';
		$popup = '';
		$noSubscriber = true;

		if (isset($params['token'])) {
			$token = $params['token'];
		}
		if (isset($params['email'])) {
			$email = $params['email'];
		}
		if (isset($params['popup'])) {
			$popup = $params['popup'];
		}

		$prepareSql = $wpdb->prepare('SELECT id FROM '.$wpdb->prefix.SGPB_SUBSCRIBERS_TABLE_NAME.' WHERE email = %s && subscriptionType = %s', $email, $popup);
		$res = $wpdb->get_row($prepareSql, ARRAY_A);
		if (!isset($res['id'])) {
			$noSubscriber = false;
		}
		$params['subscriberId'] = $res['id'];

		$subscriber = self::subscriberExists($params);
		if ($subscriber && $noSubscriber) {
			self::deleteSubscriber($params);
		}
		else if (!$noSubscriber) {
			echo '<span>Oops, something went wrong, please try again or contact the administrator to check more info.</span>';
			wp_die();
		}
	}

	public static function subscriberExists($params = array())
	{
		if (empty($params)) {
			return false;
		}

		$receivedToken = $params['token'];
		$realToken = md5($params['subscriberId'].$params['email']);
		if ($receivedToken == $realToken) {
			return true;
		}

	}

	public static function deleteSubscriber($params = array())
	{
		global $wpdb;
		$homeUrl = get_home_url();

		if (empty($params)) {
			return false;
		}
		// send email to admin about user unsubscription
		self::sendEmailAboutUnsubscribe($params);

		$prepareSql = $wpdb->prepare('UPDATE '.$wpdb->prefix.SGPB_SUBSCRIBERS_TABLE_NAME.' SET unsubscribed = 1 WHERE id = %s ', $params['subscriberId']);
		$wpdb->query($prepareSql);

		_e('<span>You have successfully unsubscribed. <a href="'.esc_attr($homeUrl).'">click here</a> to go to the home page.</span>', SG_POPUP_TEXT_DOMAIN);
		wp_die();
	}

	public static function sendEmailAboutUnsubscribe($params = array())
	{
		if (empty($params)) {
			return false;
		}

		$newsletterOptions = get_option('SGPB_NEWSLETTER_DATA');
		$receiverEmail = get_bloginfo('admin_email');
		$userEmail = $params['email'];
		$emailTitle = __('Unsubscription', SG_POPUP_TEXT_DOMAIN);
		$subscriptionFormId = (int)$newsletterOptions['subscriptionFormId'];
		$subscriptionFormTitle = get_the_title($subscriptionFormId);

		$message = __('User with '.$userEmail.' email has unsubscribed from '.$subscriptionFormTitle.' mail list', SG_POPUP_TEXT_DOMAIN);

		$headers  = 'MIME-Version: 1.0'."\r\n";
		$headers .= 'From: WordPress Popup Builder'."\r\n";
		$headers .= 'Content-type: text/html; charset=UTF-8'."\r\n"; //set UTF-8

		$sendStatus = wp_mail($receiverEmail, $emailTitle, $message, $headers);
	}

	public static function addUnsubscribeColumn()
	{
		global $wpdb;

		$sql = 'ALTER TABLE '.$wpdb->prefix.SGPB_SUBSCRIBERS_TABLE_NAME.' ADD COLUMN unsubscribed INT NOT NULL DEFAULT 0 ';
		$wpdb->query($sql);
	}

	public static function isPluginActive($key)
	{
		$allExtensions = SgpbDataConfig::allExtensionsKeys();
		$isActive = false;
		foreach ($allExtensions as $extension) {
			if (isset($extension['key']) && $extension['key'] == $key) {
				if (is_plugin_active($extension['pluginKey'])) {
					$isActive = true;
				}
			}
		}
		$isActive = true;
		
		return $isActive;
	}
}
