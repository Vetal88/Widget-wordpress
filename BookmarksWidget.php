<?php

class BookmarksWidget extends WP_Widget
{
    public function __construct()
    {
        $widget_ops = array(
            'name' => 'SENDFORM',
            'description' => 'SENDFORM ',
        );
        parent::__construct('Repo', '', $widget_ops);
    }


    public function form($instance)
    {
        extract($instance);
        $title = !empty($title) ? esc_attr($title) : 'Form';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title') ?>">Title</label>
            <input type="text" id="<?php echo $this->get_field_id('title') ?>"
                   name="<?php echo $this->get_field_name('title') ?>" value="<?php echo $title ?>" class="widefat">
        </p>
        <?php

    }

    public function widget($args, $instance)
    {
        if(!is_user_logged_in()) return;
        $bookmarks = new repo();

        echo $args['before_widget'];
        echo $args['before_title'];
        echo $instance['title'];
        echo $args['after_title'];
         $bookmarks->show_bookmarks();
        echo $args['after_widget'];
    }


}