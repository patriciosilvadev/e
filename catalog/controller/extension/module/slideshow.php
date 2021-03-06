<?php
class ControllerExtensionModuleSlideshow extends Controller {
	public function index($setting) {
		static $module = 0;		

		$this->load->model('design/banner');
		$this->load->model('tool/image');

		$this->document->addStyle('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.css');
		$this->document->addScript('catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js');

		$data['banners'] = array();

		$results = $this->model_design_banner->getBanner($setting['banner_id']);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$data['banners'][] = array(
					'title'			=> $result['title'],
					'description'	=> $result['description'],
					'link_text' 	=> $result['link_text'],
					'link' 			=> $result['link'],
					'theme' 		=> $result['color_theme'],
					'mobile_theme' 	=> 'mobile_' . $result['mobile_color_theme'],
					'image' 		=> $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']),
					'mobile_image' 	=> $this->model_tool_image->resize($result['mobile_image'], $setting['mobile_width'], $setting['mobile_height'], 'h')
				);
			}
		}

		$data['module'] = $module++;

		return $this->load->view('extension/module/slideshow', $data);
	}
}
