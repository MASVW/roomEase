<?php

namespace App\Livewire;

use Livewire\Component;

class PathComponent extends Component
{
    public $currentIframe;
    public $currentStep = 0;
    public $allReady = [];
    public $stepDone = 0;

    public $steps = [
        [
            'title' => 'Browse Room',
            'description' => 'Browse the available rooms',
            'iframe' => 'https://lottie.host/embed/c2edf008-790c-4422-b10b-f229166cb0b1/8KX4b6W7Nh.json'
        ],
        [
            'title' => 'Select Room',
            'description' => 'Select one that fits your needs',
            'iframe' => 'https://lottie.host/embed/b7b9650b-cb4b-49dd-bafe-f3e201290276/UvSwINEKEK.json'
        ],
        [
            'title' => 'Fill in the Required Details',
            'description' => 'Enter all necessary information',
            'iframe' => 'https://lottie.host/embed/2838f03d-f42f-4054-bb50-20f2a8bb65aa/KXORtGL66k.json'
        ],
        [
            'title' => 'Submit Your Booking Request',
            'description' => 'Send your request for approval',
            'iframe' => 'https://lottie.host/embed/f381b71b-6c09-4dd5-a44c-72b48092dd18/wF9e0Vuaxh.json'
        ]
    ];

    public function mount()
    {
        $this->currentIframe = $this->steps[0]['iframe'];
        $this->allReady = [false, false, false, false];
    }

    public function nextStep()
    {
        // Mark current step as ready
        $this->allReady[$this->currentStep] = true;

        // Move to the next step
        $this->currentStep = ($this->currentStep + 1) % count($this->steps);
        $this->currentIframe = $this->steps[$this->currentStep]['iframe'];

        // Reset if we've gone through all steps
        if ($this->currentStep == 0) {
            $this->allReady = [false, false, false, false];
        }

        $this->stepDone = array_sum($this->allReady);
    }

    public function render()
    {
        return view('livewire.path-component');
    }


}
