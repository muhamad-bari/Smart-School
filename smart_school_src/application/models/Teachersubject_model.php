<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Teachersubject_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->current_session = $this->setting_model->getCurrentSession();
    }

    public function get($id = null) {
        $this->db->select()->from('teacher_subjects');
        if ($id != null) {
            $this->db->where('id', $id);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function teachersjubject($id = null) {
        $this->db->select()->from('teacher_subjects');
        if ($id != null) {
            $this->db->where('teacher_id', $id);
        } else {
            $this->db->order_by('id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    public function remove($id) {
        $this->db->where('id', $id);
        $this->db->delete('teacher_subjects');
    }

    public function deleteBatch($ids, $class_section_id) {


        $this->db->where('class_section_id', $class_section_id);
        $this->db->where('session_id', $this->current_session);
        $this->db->where_not_in('id', $ids);
        $this->db->delete('teacher_subjects');
    }

    public function add($data) {
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('teacher_subjects', $data);
        } else {
            $this->db->insert('teacher_subjects', $data);
            return $this->db->insert_id();
        }
    }

    public function getDetailByclassAndSection($class_section_id) {
        $this->db->select()->from('teacher_subjects');
        $this->db->where('class_section_id', $class_section_id);
        $this->db->where('teacher_subjects.session_id', $this->current_session);
        $query = $this->db->get();
           
        return $query->result_array();
    }

    public function getDetailbyClsandSection($class_id, $section_id, $exam_id) {
        $query = $this->db->query("SELECT teacher_subjects.*,exam_schedules.date_of_exam,exam_schedules.start_to,exam_schedules.end_from,exam_schedules.room_no,exam_schedules.full_marks,exam_schedules.passing_marks,subjects.name,
            subjects.type FROM `teacher_subjects` LEFT JOIN `exam_schedules` ON exam_schedules.teacher_subject_id=teacher_subjects.id AND exam_schedules.exam_id = " . $this->db->escape($exam_id) . "  INNER JOIN subjects
            ON teacher_subjects.subject_id = subjects.id INNER JOIN class_sections
            ON teacher_subjects.class_section_id = class_sections.id WHERE class_sections.class_id =" . $this->db->escape($class_id) . " and class_sections.section_id=" . $this->db->escape($section_id));

        return $query->result_array();
    }

    public function getSubjectByClsandSection($class_id, $section_id,$classteacher = 'yes') {


          $userdata = $this->customlib->getUserData();
        $role_id = $userdata["role_id"];

        if (isset($role_id) && ($userdata["role_id"] == 2) && ($userdata["class_teacher"] == "yes")) {
              $cquery = $this->db->select("classes.*")->join("classes", "class_teacher.class_id = classes.id")->where("class_teacher.staff_id", $userdata["id"])->where("classes.id", $class_id)->get("class_teacher");
              if($cquery->num_rows() > 0 ){

                $classteacher = 'no';
              }else{
                $classteacher = 'yes';
              }

            if ($classteacher == 'yes') {
               
             //   $this->db->where("teacher_subjects.teacher_id",$userdata["id"]);
                $where = " and teacher_subjects.teacher_id = ".$userdata["id"];
            } else {
                $where = " ";
              
            }
        }else{
             $where = " ";

        }

    
         $sql = "SELECT teacher_subjects.*,staff.name as `teacher_name`, staff.surname, subjects.name,subjects.type,subjects.code FROM `teacher_subjects` INNER JOIN subjects ON teacher_subjects.subject_id = subjects.id INNER JOIN class_sections ON teacher_subjects.class_section_id = class_sections.id INNER JOIN staff ON staff.id = teacher_subjects.teacher_id  WHERE class_sections.class_id =" . $this->db->escape($class_id) . " and class_sections.section_id=" . $this->db->escape($section_id) . " and teacher_subjects.session_id=" . $this->db->escape($this->current_session). " ".$where;

        $query = $this->db->query($sql);

        return $query->result_array();
    }

    function getTeacherClassSubjects($teacher_id) {
        $this->db->select('teacher_subjects.*,subjects.name,classes.class,sections.section');
        $this->db->from('teacher_subjects');
        $this->db->join('subjects', 'subjects.id = teacher_subjects.subject_id');
        $this->db->join('class_sections', 'class_sections.id = teacher_subjects.class_section_id');
        $this->db->join('classes', 'classes.id = class_sections.class_id');
        $this->db->join('sections', 'sections.id = class_sections.section_id');
        $this->db->where('teacher_subjects.teacher_id', $teacher_id);
        $this->db->where('teacher_subjects.session_id', $this->current_session);
        $query = $this->db->get();
        return $query->result();
    }

}
