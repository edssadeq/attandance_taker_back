<?php


namespace src\models;


class Meet
{
    private string $meet_id;
    private string $meet_data_time;
    private string $meet_organiser;
    private int $meet_participants_number;
    private string $meet_notes;
    private int $course_id;

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
    public function getMeetId(): string
    {
        return $this->meet_id;
    }

    /**
     * @param string $meet_id
     */
    public function setMeetId(string $meet_id): void
    {
        $this->meet_id = $meet_id;
    }

    /**
     * @return string
     */
    public function getMeetDataTime(): string
    {
        return $this->meet_data_time;
    }

    /**
     * @param string $meet_data_time
     */
    public function setMeetDataTime(string $meet_data_time): void
    {
        $this->meet_data_time = $meet_data_time;
    }

    /**
     * @return string
     */
    public function getMeetOrganiser(): string
    {
        return $this->meet_organiser;
    }

    /**
     * @param string $meet_organiser
     */
    public function setMeetOrganiser(string $meet_organiser): void
    {
        $this->meet_organiser = $meet_organiser;
    }

    /**
     * @return int
     */
    public function getMeetParticipantsNumber(): int
    {
        return $this->meet_participants_number;
    }

    /**
     * @param int $meet_participants_number
     */
    public function setMeetParticipantsNumber(int $meet_participants_number): void
    {
        $this->meet_participants_number = $meet_participants_number;
    }

    /**
     * @return string
     */
    public function getMeetNotes(): string
    {
        return $this->meet_notes;
    }

    /**
     * @param string $meet_notes
     */
    public function setMeetNotes(string $meet_notes): void
    {
        $this->meet_notes = $meet_notes;
    }

}