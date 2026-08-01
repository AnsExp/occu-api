<?php

namespace App\Livewire\Forms;

use App\Models\MedicalDate;
use App\Models\OccupationalMedicalDate;
use Livewire\Component;

class FormOccupationalMedicine extends Component
{
    public OccupationalMedicalDate $occupationalMedicalDate;
    public $declarationQuestionsPart1 = [
        'eye_problems',
        'high_blood_pressure',
        'cardiovascular_diseases',
        'heart_surgery',
        'varicose_veins',
        'asthma_bronchitis',
        'blood_disorders',
        'diabetes',
        'thyroid_disorders',
        'digestive_problems',
        'kidney_disorders',
        'skin_disorders',
        'allergies',
        'infectious_diseases',
        'hernias',
        'genital_problems',
        'pregnancy',
        'sleep_problems',
        'substance_use?',
        'surgery',
        'epilepsy',
        'dizziness',
        'loss_of_consciousness',
        'psychiatric_problems',
        'depression',
        'suicide_attempt',
        'memory_loss',
        'severe_headaches',
        'ear_nose_throat_problems',
        'mobility_limitations',
        'back_joint_problems',
        'amputations',
        'fractures_dislocations',
    ];
    public $declarationResultsPart1 = [];
    public $declarationQuestionsPart2 = [
        'sick_leave?',
        'hospitalized?',
        'unfit_for_work?',
        'certificate_limitations?',
        'medical_problems?',
        'healthy_for_work?',
        'allergic_to_medicine?',
    ];
    public $declarationResultsPart2 = [];
    public $declarationQuestionsPart3 = [
        'taking_medicine?',
    ];
    public $declarationResultsPart3 = [];
    public $clinicalChecks = [
        'head',
        'sinuses',
        'mouth_teeth',
        'ears',
        'tympanic_membrane',
        'eyes',
        'ophthalmoscopy',
        'pupils',
        'ocular_movement',
        'lungs_thorax',
        'breast_exam',
        'heart',
        'skin',
        'varicose_veins',
        'vascular',
        'abdomen_viscera',
        'hernias',
        'anus',
        'genitourinary',
        'extremities',
        'spine',
        'neurological',
        'psychiatric',
        'general_appearance',
    ];
    public $services = [
        'deck_service',
        'machine_service',
        'food_handling',
        'radiocommunication',
        'others',
    ];
    public $diagnostics = [
        'hematimetry',
        'lipid_profile',
        'blood_chemistry',
        'hepatic_profile',
        'hiv',
    ];
    public $has_restrictions = null;
    public $do_torax_radiography = null;

    public function mount(OccupationalMedicalDate $occupationalMedicalDate)
    {
        $this->occupationalMedicalDate = $occupationalMedicalDate;
    }

    public function render()
    {
        return view('livewire.forms.form-occupational-medicine');
    }
}
