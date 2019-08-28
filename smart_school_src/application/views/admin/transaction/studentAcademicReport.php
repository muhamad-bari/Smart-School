<?php
$currency_symbol = $this->customlib->getSchoolCurrencyFormat();
?>

<div class="content-wrapper" style="min-height: 946px;">
    <section class="content-header">
        <h1>
            <i class="fa fa-money"></i> <?php echo $this->lang->line('fees_collection'); ?> <small> <?php echo $this->lang->line('filter_by_name1'); ?></small></h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-search"></i> <?php echo $this->lang->line('select_criteria'); ?></h3>
                    </div>
                    <form action="<?php echo site_url('admin/transaction/studentacademicreport') ?>"  method="post" accept-charset="utf-8">
                        <div class="box-body">
                            <?php echo $this->customlib->getCSRF(); ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('class'); ?></label><small class="req"> *</small>
                                        <select autofocus="" id="class_id" name="class_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                            <?php
                                            foreach ($classlist as $class) {
                                                ?>
                                                <option value="<?php echo $class['id'] ?>" <?php if (set_value('class_id') == $class['id']) echo "selected=selected" ?>><?php echo $class['class'] ?></option>
                                                <?php
                                                $count++;
                                            }
                                            ?>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('class_id'); ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1"><?php echo $this->lang->line('section'); ?></label><small class="req"> *</small>
                                        <select  id="section_id" name="section_id" class="form-control" >
                                            <option value=""><?php echo $this->lang->line('select'); ?></option>
                                        </select>
                                        <span class="text-danger"><?php echo form_error('section_id'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">

                            <button type="submit" class="btn btn-primary btn-sm pull-right"><i class="fa fa-search"></i> <?php echo $this->lang->line('search'); ?></button>   </div>
                    </form>
                </div>
                <?php
                if (isset($student_due_fee)) {
                    ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-info" id="transfee">
                                <div class="box-header ptbnull">
                                    <h3 class="box-title titlefix"><i class="fa fa-users"></i> <?php echo $this->lang->line('student_fees_report'); ?></h3>
                                </div>                              
                                <div class="box-body table-responsive">
                                    <div class="download_label"><?php echo $this->lang->line('student_fees_report'); ?></div>    
                                    <table class="table table-striped table-bordered table-hover example">
                                        <thead>
                                            <tr>
                                                <th class="text text-left"><?php echo $this->lang->line('student_name'); ?></th>
                                                <th class="text text-left"><?php echo $this->lang->line('admission_no'); ?></th>
                                                <th class="text text-left"><?php echo $this->lang->line('roll_no'); ?></th>
                                                <th class="text text-left"><?php echo $this->lang->line('father_name'); ?></th>

                                                <th class="text text-right"><?php echo $this->lang->line('total_fees'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                                <th class="text text-right"><?php echo $this->lang->line('discount'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                                <th class="text text-right"><?php echo $this->lang->line('fine'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                                <th class="text text-right"><?php echo $this->lang->line('paid_fees'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>

                                                <th class="text-right"><?php echo $this->lang->line('balance'); ?> <span><?php echo "(" . $currency_symbol . ")"; ?></span></th>
                                            </tr>
                                        </thead>  
                                        <tbody>   

                                            <?php
                                            $grd_total = 0;
                                            $grd_paid = 0;
                                            $grd_discount = 0;
                                            $grd_fine = 0;
                                            if (!empty($student_due_fee)) {
                                                foreach ($student_due_fee as $key => $student) {


                                                    if ($student->totalfee != "N/A") {

                                                        $grd_total = $grd_total + $student->totalfee;
                                                    }
                                                    if ($student->deposit != "N/A") {

                                                        $grd_paid = $grd_paid + $student->deposit;
                                                    }
                                                    if ($student->discount != "N/A") {

                                                        $grd_discount = $grd_discount + $student->discount;
                                                    }
                                                    if ($student->fine != "N/A") {

                                                        $grd_fine = $fine + $student->fine;
                                                    }
                                                    ?>

                                                    <tr>
                                                        <td><?php echo $student->name; ?>   </td>
                                                        <td><?php echo $student->admission_no; ?>   </td>
                                                        <td><?php echo $student->roll_no; ?></td>
                                                        <td><?php echo $student->father_name; ?>   </td>

                                                        <td class="text text-right">

                                                            <?php
                                                            if ($student->totalfee === "N/A") {
                                                                ?>
                                                                <span class="text text-red righttext">xxx</span>
                                                                <?php
                                                            } else {

                                                                echo (number_format($student->totalfee, 2, '.', ''));
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="text text-right">

                                                            <?php
                                                            if ($student->discount === "N/A") {
                                                                echo $student->discount;
                                                                ?>

                                                                <span class="text text-red righttext">xxx</span>
                                                                <?php
                                                            } else {
                                                                echo (number_format($student->discount, 2, '.', ''));
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="text text-right">

                                                            <?php
                                                            if ($student->fine === "N/A") {
                                                                ?>
                                                                <span class="text text-red righttext">xxx</span>
                                                                <?php
                                                            } else {
                                                                echo (number_format($student->fine, 2, '.', ''));
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="text text-right">

                                                            <?php
                                                            if ($student->deposit === "N/A") {
                                                                ?>
                                                                <span class="text text-red righttext">xxx</span>
                                                                <?php
                                                            } else {
                                                                echo (number_format($student->deposit, 2, '.', ''));
                                                            }
                                                            ?>
                                                        </td>
                                                        <td class="text-right">

                                                            <?php
                                                            if ($student->balance === "N/A") {
                                                                ?>
                                                                <span class="text text-red righttext">xxx</span>
                                                                <?php
                                                            } else {
                                                                echo (number_format($student->balance, 2, '.', ''));
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            } else {
                                                ?>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="8" class="text-danger text-center">
                                                        <span class="input input-danger"><?php echo $this->lang->line('no_record_found'); ?></span>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                            <?php
                                        }
                                        ?>
                                        <tr  class="box box-solid total-bg">
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                            <td class="text text-right">
                                                <?php echo $this->lang->line('grand_total'); ?>
                                            </td>
                                            <td class="text text-right">
                                                <?php echo ($currency_symbol . number_format($grd_total, 2, '.', '') ); ?>
                                            </td>
                                            <td class="text text-right">
                                                <?php echo ($currency_symbol . number_format($grd_discount, 2, '.', '') ); ?>
                                            </td>
                                            <td class="text text-right">
                                                <?php echo ($currency_symbol . number_format($grd_fine, 2, '.', '') ); ?>
                                            </td>
                                            <td class="text text-right">
                                                <?php echo ($currency_symbol . number_format($grd_paid, 2, '.', '') ); ?>
                                            </td> 

                                            <td class="text text-right">
                                                <?php echo ($currency_symbol . number_format(($grd_total - ($grd_paid + $grd_discount)), 2, '.', '')); ?>
                                            </td>
                                        </tr>

                                        </tbody> 
                                    </table>
                                </div>                            
                            </div>                       
                        </div>
                    </div>
                    <?php
                }
                ?>
                </section>
            </div>

            <script type="text/javascript">
                function getSectionByClass(class_id, section_id) {
                    if (class_id != "" && section_id != "") {
                        $('#section_id').html("");
                        var base_url = '<?php echo base_url() ?>';
                        var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
                        $.ajax({
                            type: "GET",
                            url: base_url + "sections/getByClass",
                            data: {'class_id': class_id},
                            dataType: "json",
                            success: function (data) {
                                $.each(data, function (i, obj)
                                {
                                    var sel = "";
                                    if (section_id == obj.section_id) {
                                        sel = "selected";
                                    }
                                    div_data += "<option value=" + obj.section_id + " " + sel + ">" + obj.section + "</option>";
                                });
                                $('#section_id').append(div_data);
                            }
                        });
                    }
                }
                $(document).ready(function () {
                    $(document).on('change', '#class_id', function (e) {
                        $('#section_id').html("");
                        var class_id = $(this).val();
                        var base_url = '<?php echo base_url() ?>';
                        var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
                        $.ajax({
                            type: "GET",
                            url: base_url + "sections/getByClass",
                            data: {'class_id': class_id},
                            dataType: "json",
                            success: function (data) {
                                $.each(data, function (i, obj)
                                {
                                    div_data += "<option value=" + obj.section_id + ">" + obj.section + "</option>";
                                });

                                $('#section_id').append(div_data);
                            }
                        });
                    });
                    $(document).on('change', '#section_id', function (e) {
                        getStudentsByClassAndSection();
                    });
                    var class_id = $('#class_id').val();
                    var section_id = '<?php echo set_value('section_id') ?>';
                    getSectionByClass(class_id, section_id);
                });
                function getStudentsByClassAndSection() {
                    $('#student_id').html("");
                    var class_id = $('#class_id').val();
                    var section_id = $('#section_id').val();
                    var base_url = '<?php echo base_url() ?>';
                    var div_data = '<option value=""><?php echo $this->lang->line('select'); ?></option>';
                    $.ajax({
                        type: "GET",
                        url: base_url + "student/getByClassAndSection",
                        data: {'class_id': class_id, 'section_id': section_id},
                        dataType: "json",
                        success: function (data) {
                            $.each(data, function (i, obj)
                            {
                                div_data += "<option value=" + obj.id + ">" + obj.firstname + " " + obj.lastname + "</option>";
                            });
                            $('#student_id').append(div_data);
                        }
                    });
                }

                $(document).ready(function () {
                    $("ul.type_dropdown input[type=checkbox]").each(function () {
                        $(this).change(function () {
                            var line = "";
                            $("ul.type_dropdown input[type=checkbox]").each(function () {
                                if ($(this).is(":checked")) {
                                    line += $("+ span", this).text() + ";";
                                }
                            });
                            $("input.form-control").val(line);
                        });
                    });
                });
                $(document).ready(function () {
                    $.extend($.fn.dataTable.defaults, {
                        ordering: false,
                        paging: false,
                        bSort: false,
                        info: false
                    });
                });
            </script>


