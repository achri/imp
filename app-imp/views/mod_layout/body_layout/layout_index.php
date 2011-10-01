<DIV class="ui-layout-center" style="overflow:auto"><?php $this->load->view('mod_layout/'.$layout_switch.'/layout_content');?></DIV>
<DIV class="ui-layout-north"><?php $this->load->view('mod_layout/'.$layout_switch.'/layout_header');?></DIV>
<DIV class="ui-layout-south"><?php $this->load->view('mod_layout/'.$layout_switch.'/layout_footer');?></DIV>
<DIV class="ui-layout-east" style="overflow:auto"><?php $this->load->view('mod_layout/'.$layout_switch.'/layout_sidebar-right');?></DIV>
<DIV class="ui-layout-west" style="overflow:auto"><?php $this->load->view('mod_layout/'.$layout_switch.'/layout_sidebar-left');?></DIV>