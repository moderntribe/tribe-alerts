<?php declare(strict_types=1);

namespace Tribe\Alert\Meta;

use Tribe\Alert\Components\Alert\Color_Options_Manager;
use Tribe\Alert\Post_Types\Alert\Alert;
use Tribe\Alert\Traits\With_Field_Prefix;
use Tribe\Libs\ACF;
use Tribe\Libs\ACF\Field;

class Alert_Meta extends ACF\ACF_Meta_Group {

	use With_Field_Prefix;

	public const NAME = 'tribe_alert_meta';

	public const MAX_POSTS = 25;

	public const FIELD_MESSAGE = 'alert_message';

	public const GROUP_CTA                = 'alert_cta';
	public const FIELD_CTA_LINK           = 'cta';
	public const FIELD_CTA_ADD_ARIA_LABEL = 'add_aria_label';
	public const FIELD_CTA_ARIA_LABEL     = 'aria_label';

	public const GROUP_RULES               = 'alert_rules';
	public const FIELD_RULES_DISPLAY_TYPE  = 'display_type';
	public const FIELD_RULES_INCLUDE_PAGES = 'include_pages';
	public const FIELD_RULES_EXCLUDE_PAGES = 'exclude_pages';

	public const FIELD_COLOR = 'alert_color';

	public const OPTION_EVERY_PAGE = 'every_page';
	public const OPTION_INCLUDE    = 'include';
	public const OPTION_EXCLUDE    = 'exclude';

	protected Color_Options_Manager $color_options;

	public function __construct( array $object_types, Color_Options_Manager $color_options ) {
		parent::__construct( $object_types );
		$this->color_options = $color_options;
	}

	public function get_keys(): array {
		return [
			self::FIELD_MESSAGE,
			self::GROUP_CTA,
			self::GROUP_RULES,
			self::FIELD_COLOR,
		];
	}

	protected function get_group_config(): array {
		$group = new ACF\Group( self::NAME, $this->object_types );
		$group->set( 'title', esc_html__( 'Alert Settings', 'tribe-alerts' ) );

		$group->add_field( $this->get_alert_message_field() );
		$group->add_field( $this->get_cta_group() );
		$group->add_field( $this->get_rules_group() );

		if ( defined( 'TRIBE_ALERTS_COLOR_OPTIONS' ) && true === TRIBE_ALERTS_COLOR_OPTIONS ) {
			$group->add_field( $this->get_colors_field() );
		}

		return $group->get_attributes();
	}

	/**
	 * The alert message / description.
	 */
	private function get_alert_message_field(): ACF\Field {
		$field = new ACF\Field( self::NAME . '_' . self::FIELD_MESSAGE );

		$field->set_attributes( [
			'label'             => esc_html__( 'Message', 'tribe-alerts' ),
			'name'              => self::FIELD_MESSAGE,
			'type'              => 'textarea',
			'instructions'      => esc_html__( 'The message to display below the title.', 'tribe-alerts' ),
			'required'          => false,
			'conditional_logic' => false,
			'default_value'     => '',
			'placeholder'       => esc_attr__( '', 'tribe-alerts' ),
			'maxlength'         => '', // (int)
			'rows'              => '', // (int)
			'new_lines'         => '', // wpautop, br, ''
		] );

		return $field;
	}

	private function get_cta_group(): ACF\Field_Group {
		$group = new ACF\Field_Group( self::NAME . '_' . self::GROUP_CTA, [
			'label'  => esc_html__( 'Call to Action', 'tribe-alerts' ),
			'name'   => self::GROUP_CTA,
			'layout' => 'block',
		] );

		$fields = [];

		$fields[] = new Field( self::GROUP_CTA . '_' . self::FIELD_CTA_LINK, [
			'label'   => esc_html__( 'Link', 'tribe-alerts' ),
			'name'    => self::FIELD_CTA_LINK,
			'type'    => 'link',
			'wrapper' => [
				'class' => 'tribe-acf-hide-label',
			],
		] );

		$fields[] = new Field( self::GROUP_CTA . '_' . self::FIELD_CTA_ADD_ARIA_LABEL, [
			'label'   => esc_html__( 'Add Screen Reader Text', 'tribe-alerts' ),
			'name'    => self::FIELD_CTA_ADD_ARIA_LABEL,
			'type'    => 'true_false',
			'message' => esc_html__( 'Add Screen Reader Text', 'tribe-alerts' ),
			'wrapper' => [
				'class' => 'tribe-acf-hide-label',
			],
		] );

		$fields[] = new Field( self::GROUP_CTA . '_' . self::FIELD_CTA_ARIA_LABEL, [
			'label'             => __( 'Screen Reader Label', 'tribe-alerts' ),
			'instructions'      => __(
				'A custom label for screen readers if the button\'s action or purpose isn\'t easily identifiable.',
				'tribe-alerts'
			),
			'name'              => self::FIELD_CTA_ARIA_LABEL,
			'type'              => 'text',
			'conditional_logic' => [
				[
					[
						'field'    => $this->get_key_with_prefix( self::FIELD_CTA_ADD_ARIA_LABEL, self::GROUP_CTA ),
						'operator' => '==',
						'value'    => 1,
					],
				],
			],
		] );

		foreach ( $fields as $field ) {
			$group->add_field( $field );
		}

		return $group;
	}

	private function get_rules_group(): ACF\Field_Group {
		$group = new ACF\Field_Group( self::NAME . '_' . self::GROUP_RULES, [
			'label'  => esc_html__( 'Display Rules', 'tribe-alerts' ),
			'name'   => self::GROUP_RULES,
			'layout' => 'block',
		] );

		$fields = [];

		$fields[] = new Field( self::GROUP_RULES . '_' . self::FIELD_RULES_DISPLAY_TYPE, [
			'label'         => esc_html__( 'Show', 'tribe-alerts' ),
			'name'          => self::FIELD_RULES_DISPLAY_TYPE,
			'type'          => 'radio',
			'choices'       => [
				self::OPTION_EVERY_PAGE => esc_html__( 'Show on every page', 'tribe-alerts' ),
				self::OPTION_INCLUDE    => esc_html__( 'Show only on specified pages', 'tribe-alerts' ),
				self::OPTION_EXCLUDE    => esc_html__( 'Exclude from specific pages', 'tribe-alerts' ),
			],
			'default_value' => self::OPTION_EVERY_PAGE,
		] );

		$fields[] = new Field( self::GROUP_RULES . '_' . self::FIELD_RULES_INCLUDE_PAGES, [
			'label'             => esc_html__( 'Select pages where the alert will appear', 'tribe-alerts' ),
			'name'              => self::FIELD_RULES_INCLUDE_PAGES,
			'type'              => 'relationship',
			'instructions'      => sprintf( esc_html__( 'Select up to %d posts', 'tribe-alerts' ), self::MAX_POSTS ),
			'required'          => false,
			'conditional_logic' => [
				[
					[
						'field'    => $this->get_key_with_prefix( self::FIELD_RULES_DISPLAY_TYPE, self::GROUP_RULES ),
						'operator' => '==',
						'value'    => self::OPTION_INCLUDE,
					],
				],
			],
			'post_type'         => $this->get_allowed_post_types(),
			'filters'           => [
				'search',
				'post_type',
				'taxonomy',
			],
			'min'               => 1, // (int)
			'max'               => self::MAX_POSTS, // (int)
			'return_format'     => 'object', // object, id
		] );

		$fields[] = new Field( self::GROUP_RULES . '_' . self::FIELD_RULES_EXCLUDE_PAGES, [
			'label'             => esc_html__( 'Will appear on every page but the following selected pages', 'tribe-alerts' ),
			'name'              => self::FIELD_RULES_EXCLUDE_PAGES,
			'type'              => 'relationship',
			'instructions'      => sprintf( esc_html__( 'Select up to %d posts', 'tribe-alerts' ), self::MAX_POSTS ),
			'required'          => false,
			'conditional_logic' => [
				[
					[
						'field'    => $this->get_key_with_prefix( self::FIELD_RULES_DISPLAY_TYPE, self::GROUP_RULES ),
						'operator' => '==',
						'value'    => self::OPTION_EXCLUDE,
					],
				],
			],
			'post_type'         => $this->get_allowed_post_types(),
			'filters'           => [
				'search',
				'post_type',
				'taxonomy',
			],
			'min'               => 1, // (int)
			'max'               => self::MAX_POSTS, // (int)
			'return_format'     => 'object', // object, id
		] );

		foreach ( $fields as $field ) {
			$group->add_field( $field );
		}

		return $group;
	}

	private function get_colors_field(): ACF\Field {
		$field = new ACF\Field( self::NAME . '_' . self::FIELD_COLOR );

		$field->set_attributes( [
			'label'         => esc_html__( 'Color Theme', 'tribe-alerts' ),
			'instructions'  => esc_html__( 'Select a background color', 'tribe-alerts' ),
			'name'          => self::FIELD_COLOR,
			'type'          => 'swatch',
			'allow_null'    => false,
			'default_value' => '',
			'choices'       => $this->color_options->get_acf_options(),
		] );

		return $field;
	}

	private function get_allowed_post_types(): array {
		return acf_get_post_types( [
			'exclude' => [
				Alert::NAME,
				'attachment',
			],
		] );
	}

}
