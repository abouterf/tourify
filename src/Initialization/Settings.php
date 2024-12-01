<?php

namespace Abouterf\Tourify\Initialization;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 *
 */
class Settings
{
    /**
     * @return void
     */
    public function register(): void
    {
        add_action('carbon_fields_register_fields', [$this, 'addThemeSettingsPage']);
    }

    /**
     * @return void
     */
    public function addThemeSettingsPage(): void
    {
        $container = Container::make('theme_options', __('Tourify Settings', 'tourify'))
            ->set_page_parent('themes.php')
            ->add_tab(__('General Settings'), [
                Field::make('image', 'logo', __('Logo'))->set_help_text('Upload the logo for your site.'),
                Field::make('image', 'favicon', __('Favicon'))->set_help_text('Upload the favicon for your site.'),
                Field::make('select', 'layout', __('Site Layout'))
                    ->add_options([
                        'full-width' => 'Full Width',
                        'boxed' => 'Boxed',
                    ])
                    ->set_help_text('Choose the overall layout style of the site.'),
                Field::make('color', 'primary_color', __('Primary Color')),
                Field::make('color', 'secondary_color', __('Secondary Color')),
                Field::make('color', 'background_color', __('Background Color')),
            ])
            ->add_tab(__('Design Settings'), [
                Field::make('text', 'font_family', __('Font Family'))->set_help_text('Specify the font family to use. E.g., "Open Sans"'),
                Field::make('text', 'base_font_size', __('Base Font Size'))->set_help_text('Set the base font size in pixels.'),
                Field::make('textarea', 'custom_css', __('Custom CSS'))->set_help_text('Add your custom CSS for styling adjustments.'),
            ])
            ->add_tab(__('Social & Footer Settings'), [
                Field::make('text', 'facebook_url', __('Facebook URL'))->set_help_text('Enter your Facebook profile or page URL.'),
                Field::make('text', 'twitter_url', __('Twitter URL'))->set_help_text('Enter your Twitter profile URL.'),
                Field::make('text', 'instagram_url', __('Instagram URL'))->set_help_text('Enter your Instagram profile URL.'),
                Field::make('text', 'linkedin_url', __('LinkedIn URL'))->set_help_text('Enter your LinkedIn profile URL.'),
                Field::make('text', 'footer_text', __('Footer Text'))->set_help_text('Text that will appear in the footer.'),
                Field::make('textarea', 'footer_custom_code', __('Footer Custom Code'))->set_help_text('Add any custom code (HTML/JavaScript) to the footer.'),
            ]);
    }
}
