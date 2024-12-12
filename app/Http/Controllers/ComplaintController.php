<?php

namespace App\Http\Controllers;

use App\Filter\Complaints\ComplaintFilter;
use App\Models\CommentComplaint;
use App\Models\CommentStatus;
use App\Models\ProviderComplaint;
use App\Models\SideCompany;
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



class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Complaint::class);

        $hasSorting = $request->has(['sortBy', 'sortDesc']);




        return response(
            Complaint::
                with([
                    'reasons',
                    'culprits',
                    'contractor',
                    'transfer.attachments',
                    'commentstatuses',
                    'chassises' => function($query){
                    $query->select('id', 'number');
                    },
                ])->
            withCount([
                'expenses AS expense_sum' => function ($query) use ($request) {
                    if ($request->has(['data_expenses'])) {
                        $resultExp = $this->setMonth($request);
                        $query->whereIn('start_at', $resultExp)->select(\DB::raw('sum(sum)'));
                    } else {
                        $query->select(\DB::raw('sum(sum)'));
                    }
                },
            ])
                ->orderBy('pretension_at', 'desc')
                ->filter(new ComplaintFilter($request->query()))
                ->paginate($request->itemsPerPage)
            );


    }

    public function create()
    {
       // $this->authorize('create', Complaint::class);

        //загрузить справочники
        return [
            'warranty_types' => WarrantyType::get(),
            'reason' => Reason::get(),
            'type_comps' => TypeComp::get(),
            'culprits' => Culprit::get(),
            'executors' => Executor::get(),
            'contractors' => Contractor::get(),
            'providers' => ProviderComplaint::get(),
            'warranty_decrees' => WarrantyDecree::get(),
            'attachment_rules' => AttachFile::rules(),
            'expenses' => Expense::get(),
            'commentstatuses'=> CommentStatus::get(),

        ];
    }

    public function store(StoreComplaintPost $request)
    {

        $this->authorize('create', Complaint::class);

        $complaint = new Complaint($request->all());
        $complaint->status_id = 1;
        $complaint->save();


        if ($request->has('attachments')) {
            foreach ($request->attachments as $file) {
                $complaint->saveAttachment($file);
            };
        };


        if (($request->chassises) != null){
                $chassised = new Chassis();                          //создать строку в таблице
                $chassised->number = $request->chassises;                      //обращаюсь к столбцу
                $chassised->complaint_id = $complaint->id;
                $chassised->save();
        };


        if (($request->sideCompanies) != null){
            $sideComp = new SideCompany();
            $sideComp->name = $request->sideCompanies;//обращаюсь к столбцу
            $sideComp->complaint_id = $complaint->id;
            $sideComp->save();
        };


        if ($request->has('executor_id')) {
            foreach ($request->executor_id as $executorId) {
                $complaint->executors()->attach($executorId);
            };
        };

        if ($request->has('reason_id')) {
            foreach ($request->reason_id as $reasonId) {

                $complaint->reasons()->attach($reasonId);
            }
        }

        if ($request->has('culprit_id')) {
            foreach ($request->culprit_id as $culpritId) {

                $complaint->culprits()->attach($culpritId);
            }
        }


    }


    public function show($id)
    {
        $complaint = Complaint::findOrFail($id);

        $this->authorize('view', $complaint);

        $executors = $complaint->executors->pluck('name')->toArray();


        $reasons = $complaint->reasons->pluck('name')->toArray();
        $culprits = $complaint->culprits->pluck('name')->toArray();


        $arrChassis = $complaint->chassises->pluck('number')->toArray();
        $complaint->chassises = $complaint->chassises->pluck('number');

        $sideComp = $complaint->sideCompanies->pluck('name');
        $complaint->sideCompanies = $complaint->sideCompanies->pluck('name');



        $contractor_name = $complaint->contractor->name;
       // $provider_name = optional($complaint->providers)->name;
        $warranty_type_name = $complaint->warranty_type->name;

       if($complaint->type_comp) {
           $type_comp_name = $complaint->type_comp->name;
       } else {$type_comp_name = null;}

        return [
            'complaint' => $complaint,
            'chassises' => $arrChassis,
            'executor_id' => $executors,
            'reason_id' => $reasons,
            'culprit_id' => $culprits,
            'contractor_name' => $contractor_name,
            //'provider_name' => $provider_name,
            'warranty_type_name' => $warranty_type_name,
             'type_comp_name' => $type_comp_name,
            'sideCompanies' => $sideComp,

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

        $strChassis = $complaint->chassises->pluck('number')->join(',');
        $complaint->chassises = $complaint->chassises->pluck('number')->join(',');

        $sideComp = $complaint->sideCompanies->pluck('name')->join(',');
        $complaint->sideCompanies = $complaint->sideCompanies->pluck('name')->join(',');


        return [
            'executor_id' => $executors,
            'culprit_id' => $culprits,
            'reason_id' => $reasons,
            'warranty_types' => WarrantyType::get(),
            'reason' => Reason::get(),
            'type_comps' => TypeComp::get(),
            'culprits' => Culprit::get(),
            'executors' => Executor::get(),
            'chassises' => $strChassis,
            'sideCompanies' => $sideComp,
            'contractors' => [$complaint->contractor],
           'providers' => ProviderComplaint::get(),
            'warranty_decrees' => WarrantyDecree::get(),
            'complaint' => $complaint
        ];
    }

    public function update(StoreComplaintPost $request, $id)
    {
        // обращаемся в объект за id
        $complaint = Complaint::findOrFail($id);


        $complaint->executors()->sync($request->executor_id);

        $complaint->reasons()->sync($request->reason_id);
        $complaint->culprits()->sync($request->culprit_id);

        //найти шасси по id
        $chassi = Chassis::firstWhere('complaint_id', $complaint->id);

        //запись есть - обновить
        if ($chassi) {
            $chassi->update([
               'number' => $request->chassises,
            ]);
        }
        else {
           Chassis::create([
               'number' => $request->chassises,
               'complaint_id' => $complaint->id,
           ]);
        };

        $sideComp = SideCompany::firstWhere('complaint_id', $complaint->id);
        if ($sideComp) {
            $sideComp->update([
                'name' => $request->sideCompanies,
            ]);
        }
        else {
            SideCompany::create([
                'name' => $request->sideCompanies,
                'complaint_id' => $complaint->id,
            ]);
        }


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
        foreach($complaint->expenses as $item) {
            $item->delete();
        }
        foreach($complaint->redress as $item) {
            $item->delete();
        }



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
        whereYear('pretension_at', $request->input('year'))
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

            $pretension_at = strtotime($complaints[$i]->pretension_at);
            $pretension_at = date('d.m.Y', $pretension_at);

            $close_at = strtotime($complaints[$i]->close_at);
            $close_date = date('d.m.Y', $close_at);

            $culpritNames = $complaints[$i]->culprits->pluck('name')->join(', ');
            $reasonsNames = $complaints[$i]->reasons->pluck('name')->join(', ');


            $sheet->setCellValue('A' . ($i + 2), $complaints[$i]->id)->getColumnDimension('A');
            $sheet->setCellValue('B' . ($i + 2), $pretension_at)->getColumnDimension('B');
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

    private function setMonth(Request $request): array
    {
        //преобразовать период фильтрации
        if ($request->has(['data_expenses'])) {
            return array_map(function ($date) {
                return $date . '-01';
            }, $request->input('data_expenses')) ;

        }

        return [];
    }
}
