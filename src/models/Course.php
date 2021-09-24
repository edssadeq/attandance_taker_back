<?php


namespace src\models;


class Course
{
    private int $course_id;
    private string $course_name;
    private string $course_description;
    private int $coure_meets_num;

    /**
     * @return int
     */
    public function getCourseId(): int
    {
        return $this->course_id;
    }

    /**
     * @param int $course_id
     */
    public function setCourseId(int $course_id): void
    {
        $this->course_id = $course_id;
    }

    /**
     * @return string
     */
    public function getCourseName(): string
    {
        return $this->course_name;
    }

    /**
     * @param string $course_name
     */
    public function setCourseName(string $course_name): void
    {
        $this->course_name = $course_name;
    }

    /**
     * @return string
     */
    public function getCourseDescription(): string
    {
        return $this->course_description;
    }

    /**
     * @param string $course_description
     */
    public function setCourseDescription(string $course_description): void
    {
        $this->course_description = $course_description;
    }

    /**
     * @return int
     */
    public function getCoureMeetsNum(): int
    {
        return $this->coure_meets_num;
    }

    /**
     * @param int $coure_meets_num
     */
    public function setCoureMeetsNum(int $coure_meets_num): void
    {
        $this->coure_meets_num = $coure_meets_num;
    }

}