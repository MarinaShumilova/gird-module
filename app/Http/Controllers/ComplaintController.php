<?php

namespace App\Http\Controllers;

use App\Models\ProviderComplaint;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Http\Requests\StoreComplaintPost;
use App\Models\AttachFile;
use App\Models\Chassis;
use App\Models\Complaint;
use App\Models\Contractor;
use App\Models\Culprit;
use App\Models\Executor;
use App\Models\Expense;
use App\Models\Reason;
use App\Models\TypeComp;
use App\Models\WarrantyDecree;
use App\Models\WarrantyType;
use Illuminate\Http\Request;
use PhpParser\Builder;
use function Symfony\Component\Translation\t;


class ComplaintController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Complaint::class);

        return response(
            Complaint::
            when($request->input('data_expenses'), function ($q) use ($request) {
                $q->whereHas('expenses', function ($q) use ($request) {
                    if ($request->has(['data_expenses'])) {
                        $resultExp = array_map(function ($date) {
                            return $date . '-01';
                        }, $request->input('data_expenses'));

                        $q->whereIn('start_at', $resultExp);
                    }

                });

            })->

            when($request->input('status_filter'), function ($q) use ($request) {
                $q->where('status_id', $request->input('status_filter'));
            })->

            when($request->input('warranty_types'), function ($q) use ($request) {
                $q->where('warranty_type_id', $request->input('warranty_types'));
            })->

            with([
                'reasons',
                'culprits',
                'contractor',
                'transfer'

            ])
                ->withCount([
                    'expenses AS expense_sum' => function ($query) {
                        $query->select(\DB::raw('sum(sum)'));
                    }
                ])->orderBy('created_at', 'desc')->paginate($request->itemsPerPage)
        );


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return array
     */
    public function create()
    {
        // $this->authorize('create', Complaint::class);

        //считать данные
        return [
            'warranty_types' => WarrantyType::get(),
            'reason' => Reason::get(),
            'type_comps' => TypeComp::get(),
            'culprits' => Culprit::get(),
            'executors' => Executor::get(),
            'contractors' => Contractor::get(),
            'providers'=>ProviderComplaint::get(),
            'warranty_decrees' => WarrantyDecree::get(),
            'attachment_rules' => AttachFile::rules(),
            'expenses' => Expense::get(),


        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComplaintPost $request)
    {



        $this->authorize('create', Complaint::class);


        $complaint = new Complaint($request->all());


        $complaint->status_id = 1;


        $complaint->save();

        // dd($request->culprit_id);


        if ($request->has('attachments')) {
            foreach ($request->attachments as $file) {
                $complaint->saveAttachment($file);

            };
        };


        if ($request->has('chassises')) {
            foreach ($request->chassises as $chassis) {
                $chassised = new Chassis();                          //создать строку в таблице

                $chassised->number = $chassis;                      //обращаюсь к столбцу
                $chassised->complaint_id = $complaint->id;
                $chassised->save();
            };
        };


        if ($request->has('executor_id')) {
            foreach ($request->executor_id as $executorId) {
                $complaint->executors()->attach($executorId);
            };
        };

        if ($request->has('reason_id')) {
            foreach ($request->reason_id as $reasonId){

                $complaint->reasons()->attach($reasonId);
            }
        }

        if ($request->has('culprit_id')) {
            foreach ($request->culprit_id as $culpritId){

                $complaint->culprits()->attach($culpritId);
            }
        }



    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $complaint = Complaint::findOrFail($id);

        $this->authorize('view', $complaint);

        $executors = $complaint->executors->pluck('name')->toArray();


        $reasons = $complaint->reasons->pluck('name')->toArray();
        $culprits = $complaint->culprits->pluck('name')->toArray();


        $arrChassis = $complaint->chassises->pluck('number')->toArray();

        $contractor_name = $complaint->contractor->name;

        $provider_name = optional($complaint->providers)->name;

        $warranty_type_name = $complaint->warranty_type->name;
        $type_comp_name = $complaint->type_comp->name;



        return [
            'complaint' => $complaint,
            'chassises' => $arrChassis,
            'executor_id' => $executors,
            'reason_id'=>$reasons,
            'culprit_id'=>$culprits,
            'contractor_name' => $contractor_name,
            'provider_name'=>$provider_name,
            'warranty_type_name' => $warranty_type_name,
            'type_comp_name' => $type_comp_name,
        ];


    }


    public function edit($id)
    {

        $complaint = Complaint::findOrFail($id);

        $this->authorize('update', $complaint);

        $executors = $complaint->executors->pluck('id');       //сделать ключ, передать га фронт
        $executors->all();

        $reasons = $complaint->reasons->pluck('id');
        $reasons->all();

        $culprits = $complaint->culprits->pluck('id');
        $culprits->all();


        $arrChassis = $complaint->chassises->pluck('number')->toArray();


        $complaint->chassises = $complaint->chassises->pluck('number');


        return [
            'executor_id' => $executors,
            'culprit_id' => $culprits,
            'reason_id'=> $reasons,
            'warranty_types' => WarrantyType::get(),
            'reason' => Reason::get(),
            'type_comps' => TypeComp::get(),
            'culprits' => Culprit::get(),
            'executors' => Executor::get(),
            'chassises' => $arrChassis,
            'contractors' => [$complaint->contractor],
            'providers'=>ProviderComplaint::get(),
            'warranty_decrees' => WarrantyDecree::get(),
            'complaint' => $complaint
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreComplaintPost $request, $id)
    {
        // обращаемся в объект за id
        $complaint = Complaint::findOrFail($id);


        $complaint->executors()->sync($request->executor_id);

        $complaint->reasons()->sync($request->reason_id);
        $complaint->culprits()->sync($request->culprit_id);




        $arrOldChassis = $complaint->chassises->pluck('number')->toArray();


        $chassis = (array)$request->chassises;

        foreach ($arrOldChassis as $chassisNumber) {
            $chassis = Chassis::where('number', $chassisNumber)->first();
            if ($chassis) {
                $chassis->delete();
            }

        };
        foreach ($request->chassises as $chassisNumber) {
            $chassis = Chassis::where('number', $chassisNumber)->first();
            if (!$chassis) {
                Chassis::create([
                    'number' => $chassisNumber,
                    'complaint_id' => $complaint->id
                ]);

            }

        };


        $this->authorize('update', $complaint);

        $complaint->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Complaint $complaint)
    {

        $this->authorize('delete', $complaint);

        // $complaint = Complaint::findOrFail($id);

        $complaint->delete();
    }

    public function contractors(Request $request)
    {
        return Contractor::select(['id', 'inn', 'name'])
            ->where('name', 'LIKE', '%' . $request->search . '%')
            ->orWhere('inn', 'LIKE', $request->search . '%')
            ->get();
    }


    public function excel(Request $request)
    {

        $complaints = Complaint::
        whereYear('start_at', $request->input('year'))
            ->
            with([
                'reasons',
                'culprits',
                'contractor',
            ])->withCount([
                'expenses AS expense_sum' => function ($query) {
                    $query->select(\DB::raw('sum(sum)'));
                }
            ])->get();




        $this->saveToExcel($complaints);


    }

    private function saveToExcel($complaints)
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $styleArray = [
            'font' => [
                'name' => 'Arial',
                'italic' => false,
                'strikethrough' => false,
            ],
            'alignment' => [
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'Black'],
                ],
            ],

        ];


        $sheet->setCellValue('B1', 'Дата начала')->getColumnDimension('B')->setWidth(20);
        $sheet->setCellValue('C1', 'Дата окончания')->getColumnDimension('C')->setWidth(20);
        $sheet->setCellValue('D1', 'Приказ');

        $sheet->setCellValue('E1', 'Гарантийный приказ')->getColumnDimension('E')->setWidth(20);
        $sheet->setCellValue('F1', 'Контрагент')->getColumnDimension('F')->setWidth(30);
        $sheet->setCellValue('G1', 'Причина ГС')->getColumnDimension('G')->setWidth(30);
        $sheet->setCellValue('H1', 'Виновная сторона')->getColumnDimension('H')->setWidth(20);
        $sheet->setCellValue('I1', 'Затраты');

        $sheet->getStyle('A1:I1')->applyFromArray($styleArray);

        for ($i = 0; $i < $complaints->count(); $i++) {

            $start_at = strtotime($complaints[$i]->start_at);
            $start_date = date('d.m.Y', $start_at);

            $close_at = strtotime($complaints[$i]->close_at);
            $close_date = date('d.m.Y', $close_at);

            $culpritNames =  $complaints[$i]->culprits->pluck('name')->join(', ');
            $reasonsNames =  $complaints[$i]->reasons->pluck('name')->join(', ');




            $sheet->setCellValue('A' . ($i + 2), $complaints[$i]->id)->getColumnDimension('A');
            $sheet->setCellValue('B' . ($i + 2), $start_date)->getColumnDimension('B');
            $sheet->setCellValue('C' . ($i + 2), $close_date)->getColumnDimension('C');
            $sheet->setCellValue('D' . ($i + 2), $complaints[$i]->numb_order)->getColumnDimension('D');
            $sheet->setCellValue('E' . ($i + 2), $complaints[$i]->warranty_decree)->getColumnDimension('E');
            $sheet->setCellValue('F' . ($i + 2), $complaints[$i]->contractor->name)->getColumnDimension('F');
            $sheet->setCellValue('G' . ($i + 2), $reasonsNames)->getColumnDimension('G');
            $sheet->setCellValue('H' . ($i + 2), $culpritNames)->getColumnDimension('H');
            $sheet->setCellValue('I' . ($i + 2), $complaints[$i]->expense_sum)->getColumnDimension('I');


        }


        $writer = new Xlsx($spreadsheet);
        //$writer->save('Отчет.xlsx');

        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: inline; filename="export.xlsx"');

        $writer->save('php://output');
        exit();


    }
}
