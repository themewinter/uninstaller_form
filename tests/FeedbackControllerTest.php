<?php
use PHPUnit\Framework\TestCase;
use UninstallerForm\Api\FeedbackController;

class FeedbackControllerTest extends TestCase {
    public function test_handle_feedback_saves_feedback() {
        $controller = new FeedbackController('my-plugin/my-plugin.php');

        $request = new WP_REST_Request('POST', '/feedback');
        $request->set_body_params([
            'message' => 'Great plugin!',
            'pluginSlug' => 'my-plugin',
        ]);

        $response = $controller->handle_feedback($request);
        $data = $response->get_data();

        $this->assertTrue($data['success']);
        $this->assertEquals('Great plugin!', get_option('uninstall_feedback_my-plugin'));
    }
}
