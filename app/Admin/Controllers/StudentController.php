<?php

namespace App\Admin\Controllers;

use \App\Models\Student;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class StudentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Students';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Student);

        $grid->column('ID', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('email', __('Email'));
//        $grid->column('phone', __('Phone'));
//        $grid->column('password', __('Password'));
        $grid->column('age', __('Age'));
        $grid->column('gender', __('Gender'));
        $grid->column('enabled', __('Enabled'))->switch();
        $grid->column('intro', __('Intro'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Student::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('phone', __('Phone'));
        $show->field('password', __('Password'));
        $show->field('age', __('Age'));
        $show->field('gender', __('Gender'));
        $show->field('enabled', __('Enabled'));
        $show->field('intro', __('Intro'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Student);

        $form->text('name', __('Name'));
        $form->email('email', __('Email'));
//        $form->mobile('phone', __('Phone'));
        $form->password('password', __('Password'));
        $form->number('age', __('Age'));
        $form->number('gender', __('Gender'))->default(1);
        $form->switch('enabled', __('Enabled'))->default(1);
        $form->textarea('intro', __('Intro'));

        return $form;
    }
}
