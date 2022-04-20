<div id="form">

    <form action="" id="frm" name="frm" class="d-none">

        <div class="">
            <div class="row">
                <?php
                if ($method == 'viewdata') {
                    $element_name = '<p class=""><u class="dotted mx-2 data_name"></u></p>';
                    $element_buname = '<p class=""><u class="dotted mx-2 data_bu_name"></u></p>';
                } else {
                    $html_delivery = "";
                    $select_delivery = '<select id="data_delivery" name="data_delivery" class="form-control select2" style="">';
                    $sql_delivery = $this->db->select('ID,NAME_TH')
                        ->from('delivery')
                        ->where('status', 1);
                    $q_delivery = $sql_delivery->get();
                    $num_delivery = $q_delivery->num_rows();

                    //
                    //  find selected
                    $sql_selected = $this->db->select('DELIVERY_ID')
                        ->from('retail_methodorder')
                        ->where('id', $id);
                    $q_selected = $sql_selected->get();
                    $r_selected = $q_selected->row();
                    $deleivery_id = $r_selected->DELIVERY_ID;
                    //
                    //
                    $option_deleivery = '';
                    if ($num_delivery) {

                        $selected_has = "";

                        foreach ($q_delivery->result() as $r_delivery) {
                            $selected = "";

                            if ($r_delivery->ID == $deleivery_id) {
                                $selected = "selected=selected";
                                $selected_has = 1;
                            } else {
                                $selected = "";
                            }

                            $option_deleivery .= '<option value="' . $r_delivery->ID . '" ' . $selected . ' >' . $r_delivery->NAME_TH . '</option>';
                        }
                    }

                    //
                    //  กรณี bu ที่เลือกไว้ถูกปิด แต่รายการแก้ไขนี้เลือกไว้กับ bu ที่ถูกปิดนั้น ให้แสดงข้อมูล bu ที่ถูกปิดออกมา 
                    if (!$selected_has) {
                        $sql_delivery_has = $this->db->select('ID,NAME_TH')
                            ->from('delivery')
                            ->where('id', $deleivery_id);
                        $q_delivery_has = $sql_delivery_has->get();
                        $num_delivery_has = $q_delivery_has->num_rows();
                        if ($num_delivery_has) {
                            $r_delivery_has = $q_delivery_has->row();
                            $option_deleivery .= '<option value="' . $r_delivery_has->ID . '" selected=selected >' . $r_delivery_has->NAME_TH . '</option>';
                        }
                    }
                    //
                    //

                    $html_delivery = $select_delivery . $option_deleivery . '</select>';

                    $element_name = '<input id="data_name" name="data_name" class="form-control" type="text">';
                    $element_buname = $html_delivery;
                }
                ?>
                <div class="d-flex col-md-6">
                    <div class="">
                        <label for="">ข้อมูลชื่อ :</label>
                    </div>
                    <div class="col">
                        <?php echo $element_name; ?>
                    </div>
                </div>
                <div class="d-flex col-md-6">
                    <div class="">
                        <label for="">BU :</label>
                    </div>
                    <div class="col">
                        <?php echo $element_buname; ?>
                    </div>
                </div>
                <?php
                if ($method == 'viewdata') {
                ?>
                    <div class="d-flex col-md-6 col-lg-6">
                        <label for="">โดย :</label>
                        <p class="">
                            <u class="dotted mx-2 bill_staffcreate"></u>
                        </p>
                    </div>
                    <div class="d-flex col-md-6 col-lg-6">
                        <label for="">เมื่อ :</label>
                        <p class="">
                            <u class="dotted mx-2 bill_datecreate"></u>
                        </p>
                    </div>
                    <div class="d-flex col-md-6 col-lg-6">
                        <label for="">แก้ไขโดย :</label>
                        <p class="">
                            <u class="dotted mx-2 bill_staffedit"></u>
                        </p>
                    </div>
                    <div class="d-flex col-md-6 col-lg-6">
                        <label for="">แก้ไขเมื่อ :</label>
                        <p class="">
                            <u class="dotted mx-2 bill_dateedit"></u>
                        </p>
                    </div>
                <?php
                }
                ?>
            </div>

        </div>

        <div class="row row-form-tool-btn mt-4">
            <div class="col-sm-12 text-center form-tool-btn">
                <?php
                if ($method == 'editdata') {
                    $textbtn_back = "กลับ";
                ?>
                    <button type="button" id="submitform" class="btn btn-md px-5 btn-outline-primary ">บันทึก</button>
                <?php
                } else {
                    $textbtn_back = "ปิด";
                ?>
                    <?php if (chkPermissPage('editsupplierlist')) { ?>
                        <button type="button" id="editform" class="btn btn-md px-5 btn-outline-primary ">แก้ไข</button>
                    <?php } ?>

                    <?php if (chkPermissPage('cancelsupplierlist')) { ?>
                        <button type="button" id="btn-cancel" class="btn btn-md btn-outline-danger float-right">ยกเลิกรายการ</button>
                    <?php } ?>
                <?php
                }
                ?>
                <button type="button" id="btn-back" class="btn btn-md btn-secondary"><?php echo $textbtn_back; ?></button>


            </div>
        </div>

    </form>

</div>