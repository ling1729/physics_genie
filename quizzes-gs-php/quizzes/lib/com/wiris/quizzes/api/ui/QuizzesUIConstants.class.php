<?php

class com_wiris_quizzes_api_ui_QuizzesUIConstants {
	public function __construct(){}
	static function __meta__() { $»args = func_get_args(); return call_user_func_array(self::$__meta__, $»args); }
	static $__meta__;
	static $TEXT_FIELD;
	static $INLINE_EDITOR;
	static $POPUP_EDITOR;
	static $STUDIO = "studio";
	static $INLINE_STUDIO = "inlineStudio";
	static $EMBEDDED_ANSWERS_EDITOR = "embeddedAnswersEditor";
	static $AUTHORING = "authoring";
	static $DELIVERY = "delivery";
	static $REVIEW = "review";
	function __toString() { return 'com.wiris.quizzes.api.ui.QuizzesUIConstants'; }
}
com_wiris_quizzes_api_ui_QuizzesUIConstants::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("Deprecated" => null))));
com_wiris_quizzes_api_ui_QuizzesUIConstants::$TEXT_FIELD = com_wiris_quizzes_api_QuizzesConstants::$ANSWER_FIELD_TYPE_TEXT;
com_wiris_quizzes_api_ui_QuizzesUIConstants::$INLINE_EDITOR = com_wiris_quizzes_api_QuizzesConstants::$ANSWER_FIELD_TYPE_INLINE_EDITOR;
com_wiris_quizzes_api_ui_QuizzesUIConstants::$POPUP_EDITOR = com_wiris_quizzes_api_QuizzesConstants::$ANSWER_FIELD_TYPE_POPUP_EDITOR;
