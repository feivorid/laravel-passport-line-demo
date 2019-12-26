<?php

namespace App\Admin\Controllers;

use \App\Models\Student;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;

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

        $grid->column('id', __('ID'));
        $grid->column('name', __('姓名'));
        $grid->column('email', __('邮箱'));
        //        $grid->column('phone', __('Phone'));
        //        $grid->column('password', __('Password'));
        //        $grid->column('age', __('Age'));
        //        $grid->column('gender', __('Gender'));
        $grid->column('enabled', __('状态'))->switch();
        $grid->column('intro', __('简介'));
        $grid->column('teachers', '关注的老师')->modal(function ($model) {
            $follows = $model->follows()->with(['teacher'])->where('status', 1)->get();

            if ($follows->count() > 0) {
                $teachers = collect();
                $follows->each(function ($item) use (&$teachers) {
                    $teachers->push($item->teacher);
                });
                $teachers = $teachers->map(function ($item, $key) use ($teachers) {
                    if (!$item) {
                        unset($teachers[$key]);
                    } else {
                        return $item->only(['id', 'name', 'email', 'created_at']);
                    }
                });

                return new Table(['ID', '姓名', '邮箱', '注册时间'], $teachers->toArray());
            }
        });
        $grid->column('created_at', __('创建时间'));
        $grid->column('updated_at', __('更新时间'));

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

        $form->text('name', __('姓名'));
        $form->email('email', __('邮箱'))->creationRules(['required', "unique:students"])
            ->updateRules(['required', "unique:students,email,{{id}}"]);
        //        $form->mobile('phone', __('Phone'));
        $form->password('password', __('密码'))->rules('required');
        //        $form->number('age', __('Age'));
        //        $form->number('gender', __('Gender'))->default(1);
        $form->switch('enabled', __('状态'))->default(1);
        $form->textarea('intro', __('简介'));

        $form->saving(function ($form) {
            $form->password = bcrypt($form->password);
        });

        return $form;
    }
}
