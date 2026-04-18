<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImportDataController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\PurchaseContractController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('ims');
// });

 Route::get('/', function () {
    if(Auth::check()){
        return Redirect::to('/ims');
    }
    else{
        return view('auth.login');
    }
});


Auth::routes();

Route::get('/ims', 'HomeController@index');
Route::get('/submodal', 'HomeController@indexsub');
Route::get('/showexpdate','HomeController@checkExpireDate');
Route::get('/showcurrentdate','HomeController@getCurrentDate');

Route::group(['middleware' => ['auth']], function() {

//sales hold Route start
Route::get('/sales','salesController@index');
Route::get('/showcustomer/{id}','salesController@showcustomer');
Route::post('/testd','salesController@testdata');
//Route::get('/showItemInfo/{nm}/{storeid}','salesController@showItemInfoCon');
Route::delete('/saleUOMS/{id}','salesController@getAllUoms');
Route::delete('/getsaleUOMAmount/{id}/{nid}','salesController@getConversionAmount');
Route::post('/savehold','salesController@holdStore');
Route::get('/saleholdlist','salesController@salesholdlist');
Route::get('/showhold/{id}','salesController@show');
Route::get('/getcountable','salesController@getCountHold');
Route::get('/salechildholdlist/{id}','salesController@salesholdchildlist');
Route::get('/showholdItem/{id}','salesController@showholdItem');
Route::post('/saveholditem','salesController@saveholditem');
Route::delete('/saleholditemdelete/{id}','salesController@saleholditemdelete');
Route::delete('/saleholddelete/{id}','salesController@saleholddelete');
Route::post('/saveholdcopy','salesController@saveholdcopy');
Route::get('/saleinfodholdlist/{id}','salesController@saleinfodholdlist');
Route::get('/showVat/{id}','salesController@showVat');
Route::post('/updateVatNumber','salesController@updateVatNumber');
Route::post('/updateWitholdNumber','salesController@updateWitholdNumber');
// end sale hold route

//sale route statrt
Route::get('/salelist','salesController@salelist');
Route::post('/savesale','salesController@store');
Route::get('showSale/{id}','salesController@showSale');
Route::get('/salechildsalelist/{id}','salesController@salechildsalelist');
Route::get('/showsaleItem/{id}','salesController@showSaleItem');
Route::post('/savesaleitem','salesController@savesaleitem');
Route::delete('/saleitemdelete/{id}','salesController@saleitemdelete');
Route::get('/saleinfoslateitemlist/{id}','salesController@salechildsalelist');
Route::delete('/checkedsale/{id}','salesController@checkStatus');
Route::delete('/refundsale/{id}','salesController@refundsale');

// proforma route start
Route::get('proforma','ProformaController@index');
Route::post('proformasave','ProformaController@store');
Route::get('proformalist','ProformaController@proformalist');
Route::get('proformaedit/{id}','ProformaController@edit');
Route::get('proformachildlist/{id}','ProformaController@proformachildlist');
Route::post('proformasaveitem','ProformaController@proformasaveitem');
Route::delete('/proformadelete/{id}','ProformaController@destroy');
Route::get('showproformaitem/{id}','ProformaController@show');
Route::get('proformavoid/{id}','ProformaController@proformavoid');
Route::get('proformaunvoid/{id}','ProformaController@proformaunvoid');
Route::get('getproformainfo/{id}','ProformaController@getproformainfo');
Route::get('getmemoinfo/{id}/{itcode}','ProformaController@getItemMemo');
Route::get('proformainfolist/{id}','ProformaController@proformainfolist');
// end of proforma route

//item route start
Route::get('/items','ItemController@index');
Route::delete('/itemdata','ItemController@showItemData');
Route::post('/saveitems','ItemController@store');
Route::get('/itemedit/{id}','ItemController@edit');
Route::post('/itemUpdate','ItemController@updateItem');
Route::delete('/itemdelete/{id}','ItemController@delete');
Route::get('/getimages/{id}','ItemController@getimage');
Route::get('/getbarcodes/{id}','ItemController@getbarcode');
Route::get('/getgeneratebarcode','ItemController@getgeneratebarcode');
Route::get('/getsknumber','ItemController@getsknumber');
Route::get('/showitem/{id}','ItemController@show');
Route::get('/printbarcodes/{id}','ItemController@printbarcodes');
Route::get('/printbar','ItemController@printbar');
Route::post('/printbarcodes/{id}','ItemController@printbarcodes');
Route::get('/printbar','ItemController@printbar');
Route::get('/geteset','ItemController@geteset');


//Customer Route Start
Route::get('/customer','CustomerController@index');
Route::delete('/getcustomer','CustomerController@showCustomerData');
Route::post('savecustomer','CustomerController@store');
Route::get('/custometedit/{id}','CustomerController@edit');
Route::post('/customerUpdate','CustomerController@updateCutomer');
Route::delete('/deleteCustomer/{id}', 'CustomerController@delete');
Route::get('/showCustomerInfo/{id}','CustomerController@showCustomerInfoData');
Route::get('/showCustomerDetail/{id}','CustomerController@showCusDetailData');
Route::get('/showBlInfo/{id}','CustomerController@showBlInfoData');
Route::get('/showBlDetail/{name}','CustomerController@showBlDetailData');
Route::get('/getAllCustomers','CustomerController@getAllCustomerCon');
Route::get('/getCustomerCode','CustomerController@getCustomerCodeCon');
Route::post('/getcustlastid','CustomerController@getLastId');
//Customer Route End

//MRC route starts
Route::post('/savemrc','CustomerController@storeMRC');
Route::get('/showmrc/{id}','CustomerController@showMrcData');
Route::get('/mrcupdate/{id}','CustomerController@updateMRC');
Route::delete('/mrcdelete/{id}', 'CustomerController@deleteMRC');
//MRC route ends

//Blacklist route starts
Route::get('/showBlCustomerInfo/{nm}','CustomerController@showCustomerOnBl');
Route::get('/blacklistedit/{id}','CustomerController@editBlacklist');
Route::post('/saveblacklist','CustomerController@storeBlacklist');
Route::post('/updateblacklist','CustomerController@updateBlacklist');
Route::delete('/blacklistdelete/{id}', 'CustomerController@deleteBlackList');
Route::delete('/blacklistview','CustomerController@showBlacklistData');
//Blacklist route ends


//Account route
Route::get('/account','UserController@index');
Route::post('/saverole','RoleController@store');
Route::post('/saveaccount','UserController@store');
//end of account Route

//-------------------------Category Routes Start-------------------------
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/category','CategoryController@index');
Route::delete('/categorydata','CategoryController@showCategoryData');
Route::post('savecategory','CategoryController@store');
Route::get('/catedit/{id}','CategoryController@edit');
Route::delete('/delete/{id}', 'CategoryController@delete');
Route::PUT('/catupdate/{id}','CategoryController@update');
Route::get('/category/{id}','CategoryController@getbyid');
Route::post('/catupdate','CategoryController@update');
Route::Resource('cat','CategoryController');
Route::get('/catinfos/{id}','CategoryController@catinfos');
Route::post('/fetchParentCategory','CategoryController@fetchParentCategory');
//-------------------------Category Routes Ends-------------------------

//-------------------------UOM Routes Start-------------------------
Route::get('/uom','UomController@index');
Route::delete('/uomdata','UomController@showUOMData');
Route::post('saveuom','UomController@store');
Route::get('/oumedit/{id}','UomController@edit');
Route::get('/uom/{id}','UomController@getbyid');
Route::post('/uomupdate','UomController@update');
Route::delete('/deleteuom/{id}', 'UomController@delete');
//-------------------------UOM Routes End-------------------------

// -------------------------conversion route start-------------------------
Route::get('/conversion','ConversionController@index');
Route::delete('/conversiondata','ConversionController@showConversionData');
Route::post('/saveconversion','ConversionController@store');
Route::post('/updateconversion','ConversionController@update');
Route::delete('/deleteconversion/{id}','ConversionController@delete');
Route::get('/product','ConversionController@allpro');
Route::get('/getCoversionuom','ConversionController@getCoversionuom');
Route::get('/getConversionVal/{id}','ConversionController@getConversionVal');
// -------------------------conversion route ends-------------------------

//-------------------------Store Routes Start-------------------------
Route::get('/store','StoreController@index');
Route::delete('/storedata','StoreController@showStoreData');
Route::post('savestore','StoreController@store');
Route::get('/storeedit/{id}','StoreController@edit');
Route::get('/store/{id}','StoreController@getbyid');
Route::post('/storeupdate','StoreController@update');
Route::delete('/deletestore/{id}', 'StoreController@delete');
Route::get('/getmrc','StoreController@getmrc');
Route::get('/getstore/{id}','StoreController@getstore');
Route::get('getassignedmrc/{id}','StoreController@getassignedmrc');
Route::get('getdifferentmrc/{id}','StoreController@getdifferentmrc');
Route::get('/storemrc','StoreController@storemrc');
Route::get('/savestoremrc','StoreController@savestoremrc');
Route::post('/mrcstore','StoreController@mrcstore');
Route::get('getmrcedit/{id}','StoreController@getmrcedit');
Route::delete('mrcdelete/{id}','StoreController@mrcdelete');
Route::delete('mrcinfodata/{id}','StoreController@mrcinfodata');
//-------------------------Store Routes End-------------------------

//-------------------------Location Route Start-------------------------
Route::post('/savelocation','StoreController@storeLocation');
Route::get('/showloaction/{id}','StoreController@showLocationdata');
Route::get('/locationupdate/{id}','StoreController@updateLoc');
Route::delete('/deletelocation/{id}', 'StoreController@deleteLoc');
//-------------------------Location Route End-------------------------

//-------------------------Brand Routes Start-------------------------
Route::get('/brand','BrandController@index');
Route::delete('/branddata','BrandController@showBrandData');
Route::post('savebrand','BrandController@store');
Route::post('/brandupdate','BrandController@update');
Route::delete('/deletebrand/{id}', 'BrandController@delete');
Route::get('/getbrandmodel/{id}','BrandController@getbrandmodel');
Route::delete('brandinfodata/{id}','BrandController@brandinfodata');
//-------------------------Brand Routes End-------------------------

//-------------------------Model Route Start-------------------------
Route::post('/savemodel','BrandController@storeModel');
Route::get('/showmodel/{id}','BrandController@showModelData');
Route::get('/modelupdate/{id}','BrandController@updateModel');
Route::delete('/modeldelete/{id}', 'BrandController@deleteModel');
// -------------------------Model Route End-------------------------

//----------------------------Start Device-------------------------- 
Route::get('/device','DeviceController@index');
Route::delete('/devicelist','DeviceController@deviceListCon');
Route::post('testconn','DeviceController@testconn');
Route::post('savedevice','DeviceController@store');
Route::get('/showdevice/{id}','DeviceController@showdeviceCon');
Route::post('deletedevice','DeviceController@deletedeviceCon');
Route::post('testconninfo','DeviceController@testconninfo');
Route::post('opendoorinfo','DeviceController@opendoorinfo');
Route::post('restartdeviceinfo','DeviceController@restartdeviceinfo');
//----------------------------End Device----------------------------

//----------------------------Start Branch-------------------------- 
Route::get('/branch','BranchController@index');
Route::delete('/branchlist','BranchController@branchlistcon');
Route::post('saveBranch','BranchController@store');
Route::get('/showbranch/{id}','BranchController@showbranchCon');
Route::post('deletebranch','BranchController@deleteBranch');
//----------------------------End Branch----------------------------

//----------------------------Start Department-------------------------- 
Route::get('/department','DepartmentController@index');
Route::delete('/departmentlist','DepartmentController@departmentlistcon');
Route::post('saveDepartment','DepartmentController@store');
Route::post('/getlastdepartment','DepartmentController@getlastdepartment');
Route::get('/showdepartment/{id}','DepartmentController@showdepartmentCon');
Route::post('deletedep','DepartmentController@deletedepartment');
Route::get('/showdepartmenthier','DepartmentController@showDepartmentHier');
Route::post('/fetchParentDepartment','DepartmentController@fetchParentDepartment');
//----------------------------End Department----------------------------

//----------------------------Start Salary-------------------------- 
Route::get('/salary','SalaryController@index');
Route::delete('/salarylist','SalaryController@salarylistcon');
Route::post('saveSalary','SalaryController@store');
Route::get('/showsalary/{id}','SalaryController@showsalarycon');
Route::post('deletesalary','SalaryController@deletesalary');
Route::get('/salarytypelistdata','SalaryController@salarytypelistcon');
Route::post('/showSalaryDetails/{id}','SalaryController@showSalaryDetails');
Route::post('/getTaxRange','SalaryController@getTaxRange');
//----------------------------End Salary--------------------------

//----------------------------Start Position-------------------------- 
Route::get('/position','PositionController@index');
Route::delete('/positionlist','PositionController@positionlistcon');
Route::post('savePosition','PositionController@store');
Route::get('/showposition/{id}','PositionController@showpositioncon');
Route::post('deleteposition','PositionController@deleteposition');
//----------------------------End Position--------------------------

//----------------------------Start Shift-------------------------- 
Route::get('/shift','ShiftController@index');
Route::delete('/shiftlist','ShiftController@shiftlistcon');
Route::post('saveShift','ShiftController@store');
Route::get('/showshift/{id}','ShiftController@showshift');
Route::get('/timetablelists','ShiftController@timetablelistscon');
Route::get('/timetablealllists','ShiftController@timetablealllistscon');
Route::delete('/shiftdetlist/{id}','ShiftController@shiftdetlist');
Route::post('deleteshift','ShiftController@deleteshift');
Route::post('/showShiftData','ShiftController@showShiftData');
//----------------------------End Shift---------------------------- 

//---------------------Start Employee------------------------------
Route::get('/employee','EmployeeController@index');
Route::post('saveHrEmployee','EmployeeController@store');
Route::delete('/emplist','EmployeeController@employeelist');
Route::get('/showemployee/{id}','EmployeeController@showemployeecon');
Route::post('getSalaries','EmployeeController@getSalaries');
Route::post('getDayDiff','EmployeeController@getDayDiff');
Route::post('getEmployeeFaceid','EmployeeController@getEmployeeFaceid');
Route::post('getEmployeeFingerprint','EmployeeController@getEmployeeFingerprint');
Route::post('deleteEmployee','EmployeeController@deleteEmployee');
Route::get('/showemployeelist','EmployeeController@showemployeelist');
Route::post('/getlatestEmp','EmployeeController@getlatestEmp');
Route::get('/leavetypelist','EmployeeController@leavetypecon');
Route::post('/showfixedsalary/{id}','EmployeeController@showFixedSalary');
Route::post('/shownegsalary/{id}','EmployeeController@showNegSalary');
Route::post('/showEmpLeaveAlloc/{id}','EmployeeController@showEmpLeaveAlloc');

Route::post('showEmployeeLeaveAlloc','EmployeeController@showEmployeeLeaveAlloc');
Route::post('saveLeaveAllocation','EmployeeController@saveLeaveAllocation');
Route::get('/showleavealloc/{id}','EmployeeController@showleavealloc');
Route::post('voidLeaveAllocation','EmployeeController@voidLeaveAllocation');
Route::post('undoVoidLeaveAlloc','EmployeeController@undoVoidLeaveAlloc');
Route::post('saveEmpSalary','EmployeeController@saveEmpSalary');

Route::post('/getRoleData','EmployeeController@getRoleData');
Route::post('/getHrSetting','EmployeeController@getHrSetting');
Route::post('/getSelectedRoleAndAssign/{id}','EmployeeController@getSelectedRoleAndAssign');
Route::post('/getEmployeeDocuments','EmployeeController@getEmployeeDocuments');
Route::post('/getEmployeeSkillSet','EmployeeController@getEmployeeSkillSet');
Route::get('/openEmployeeDoc/{id}/{doc_name}/{type}','EmployeeController@openEmployeeDoc');

Route::post('showPayrollData','EmployeeController@showPayrollData');
Route::get('/showSalaryData/{id}','EmployeeController@showSalaryData');
Route::post('salaryForwardAction','EmployeeController@salaryForwardAction');
Route::post('salaryBackwardAction','EmployeeController@salaryBackwardAction');
Route::post('voidSalary','EmployeeController@voidSalary');
Route::post('undoVoidSalary','EmployeeController@undoVoidSalary');

Route::post('leaveAllocForwardAction','EmployeeController@leaveAllocForwardAction');
Route::post('leaveAllocBackwardAction','EmployeeController@leaveAllocBackwardAction');

Route::post('/getLeaveHistory','EmployeeController@getLeaveHistory');
Route::post('/resetEmpPass','EmployeeController@resetEmpPass');
Route::post('/countEmployeeStatus','EmployeeController@countEmployeeStatus');
Route::post('/countEmpLeaveAndSalary','EmployeeController@countEmpLeaveAndSalary');
//---------------------------End Employee--------------------------

//----------------------------Start Time Table-------------------------- 
Route::get('/timetable','TimetableController@index');
Route::delete('/timetablelist','TimetableController@timetablelistcon');
Route::post('saveTimetable','TimetableController@store');
Route::get('/showtimetable/{id}','TimetableController@showtimetablecon');
Route::post('deletetimetable','TimetableController@deletetimetablecon');
//----------------------------End Time Table---------------------------- 

//----------------------------Start Leave Management--------------- 
Route::get('/leavemgt','LeaveManagementController@index');
Route::delete('/leavelist','LeaveManagementController@leavelistcont');
Route::post('saveLeaveReq','LeaveManagementController@store');
Route::get('/showleave/{id}','LeaveManagementController@showleavecon');
Route::post('getLeaveDiff','LeaveManagementController@getLeaveDiff');
Route::post('getLeaveBalance','LeaveManagementController@getLeaveBalance');
Route::post('/approveLeaveReq','LeaveManagementController@approveLeaveReq');
Route::post('/rejLeaveReq','LeaveManagementController@rejectLeaveReq');
Route::post('/commLeaveReq','LeaveManagementController@commentLeaveReq');
Route::post('/voidLeaveReq','LeaveManagementController@voidLeaveReq');
Route::post('/undoVoidLeaveReq','LeaveManagementController@undoVoidLeaveReq');

Route::get('/showEmployeeData/{id}','LeaveManagementController@showEmployeeData');
Route::post('calcLeaveBalance','LeaveManagementController@calcLeaveBalance');
Route::post('calcEndDate','LeaveManagementController@calcEndDate');
Route::get('/downloadLeaveDoc/{id}/{file}','LeaveManagementController@downloadLeaveDoc');
Route::post('/showLeaveType','LeaveManagementController@showLeaveType');
Route::post('leaveReqForwardAction','LeaveManagementController@leaveReqForwardAction');
Route::post('leaveReqBackwardAction','LeaveManagementController@leaveReqBackwardAction');
//----------------------------End Leave Management----------------- 

//----------------------------Start Shift Schedule----------------- 
Route::get('/shiftsch','ShiftScheduleController@index');
Route::delete('/empshiftlist','ShiftScheduleController@employeeshiftlist');
Route::get('/deplist','ShiftScheduleController@departmentlist');
Route::get('/showshiftsch/{id}','ShiftScheduleController@showshiftschcon');
Route::post('saveShiftSchedule','ShiftScheduleController@store');
Route::post('saveIndShift','ShiftScheduleController@saveIndShift');
Route::post('/singletimetable','ShiftScheduleController@singletimetable');
Route::post('showShiftScheduleDetail','ShiftScheduleController@showShiftScheduleDetail');
Route::post('/getScheduleDetail','ShiftScheduleController@getScheduleDetail');
Route::post('/showTimetableData','ShiftScheduleController@showTimetableData');
Route::post('/voidSchedule','ShiftScheduleController@voidSchedule');
Route::post('/undoVoidSchedule','ShiftScheduleController@undoVoidSchedule');
//----------------------------End Shift Schedule----------------- 

//----------------------------Start Holiday-------------------------- 
Route::get('/holiday','HolidayController@index');
Route::delete('/holidaylist','HolidayController@holidaylistcon');
Route::post('saveHoliday','HolidayController@store');
Route::get('/showholiday/{id}','HolidayController@showholidaycon');
Route::post('deleteholiday','HolidayController@deleteholidaycon');
//----------------------------End Holiday---------------------------- 

//----------------------------Start Leave Type-------------------------- 
Route::get('/leavetype','LeaveTypeController@index');
Route::delete('/leavetypelist','LeaveTypeController@leavetypelistcon');
Route::post('saveLeaveType','LeaveTypeController@store');
Route::get('/showleavetype/{id}','LeaveTypeController@showleavetypecon');
Route::post('deleteleavetype','LeaveTypeController@deleteleavetypecon');
//----------------------------End Leave Type----------------------------

//----------------------------Start Salary Type-------------------------- 
Route::get('/salarytype','SalaryTypeController@index');
Route::delete('/salarytypelist','SalaryTypeController@salarytypelistcon');
Route::post('saveSalaryType','SalaryTypeController@store');
Route::get('/showsalarytype/{id}','SalaryTypeController@showsalarytypecon');
Route::post('deletesalarytype','SalaryTypeController@deletesalarytypecon');
//----------------------------End Salary Type----------------------------

//----------------------------Start Attendance-------------------------- 
Route::get('/attendance','AttendanceController@index');
Route::delete('/attendancelists/{mn}','AttendanceController@attendancelists');
Route::post('saveAttendance','AttendanceController@store');
Route::post('updateAttendance','AttendanceController@updateAtt');
Route::post('importAttendance','AttendanceController@importAtt');
Route::post('importExcelAtt','AttendanceController@importExcelAtt');
Route::get('/employeelists','AttendanceController@employeelists');
Route::post('/getalldays','AttendanceController@getAllDays');
Route::post('/getActivity','AttendanceController@getActivity');
Route::post('/getAttInfo','AttendanceController@attInfo');
Route::post('/getOffShift','AttendanceController@getOffShift');
Route::post('/offShiftConfirmation','AttendanceController@offShiftConfirmation');
Route::post('/checkLogRecords','AttendanceController@checkLogRecords');
Route::post('/getActivityDetail','AttendanceController@getActivityDetail');
//----------------------------End Attendance-------------------------- 

//----------------------------Start Overtime-------------------------- 
Route::get('/overtime','OvertimeController@index');
Route::delete('/overtimelist','OvertimeController@overtimeList');
Route::post('saveOvertime','OvertimeController@store');
Route::get('/showOvertime/{id}','OvertimeController@showOvertimeCon');
Route::post('deleteotlevel','OvertimeController@deleteotlevelcon');
//----------------------------End Overtime---------------------------- 

//----------------------------Start Payroll-------------------------- 
Route::get('/payroll','PayrollController@index');
Route::delete('/payrollList','PayrollController@payrollList');
Route::get('/payrolldep','PayrollController@departmentlist');
Route::get('/showPayrollData/{id}','PayrollController@showPayrollData');
Route::delete('/showEmployeePayroll/{id}','PayrollController@showEmployeePayroll');
Route::post('getPayrollFromMonthRange','PayrollController@getPayrollFromMonthRange');
Route::post('getPayrollToMonthRange','PayrollController@getPayrollToMonthRange');
Route::post('savePayroll','PayrollController@store');
Route::post('calcPayroll','PayrollController@calcPayroll');
Route::post('payrollDetail','PayrollController@payrollDetail');
Route::post('approvePayroll','PayrollController@approvePayroll');
Route::post('voidPayroll','PayrollController@voidPayroll');
Route::post('undovoidPayroll','PayrollController@undovoidPayroll');
Route::post('rejectPayroll','PayrollController@rejectPayroll');
Route::post('/getEmployeeTree','PayrollController@getEmployeeTree');
Route::post('/getPayrollColumns','PayrollController@getPayrollColumns');

Route::post('/getEmployeeSalaryList','PayrollController@getEmployeeSalaryList');
Route::post('/getEmployeeSalaryListInfo','PayrollController@getEmployeeSalaryListInfo');
Route::post('payrollForwardAction','PayrollController@payrollForwardAction');
Route::post('payrollBackwardAction','PayrollController@payrollBackwardAction');
Route::post('/getOtDetailData','PayrollController@getOtDetailData');
//----------------------------End Payroll---------------------------- 

//----------------------------Start Payroll Addition-------------------------- 
Route::get('/payrolladd','PayrollAdditionController@index');
Route::delete('/payrolladdlist','PayrollAdditionController@payrolladdlist');
Route::get('/payrolladdep','PayrollAdditionController@paydepartmentlist');
Route::post('getFromMonthRange','PayrollAdditionController@getFromMonthRange');
Route::post('getToMonthRange','PayrollAdditionController@getToMonthRange');
Route::post('savePayrollAdd','PayrollAdditionController@store');
Route::get('/showPayrollAdd/{id}','PayrollAdditionController@showPayrollAddCon');
Route::delete('/showEmployeeLists/{id}','PayrollAdditionController@showEmployeeListData');
Route::delete('/showSalaryCompLists/{id}','PayrollAdditionController@showSalaryCompListData');
Route::post('approvePayrollAddDed','PayrollAdditionController@approvePayrollAddDed');
Route::post('voidPayrollAddDed','PayrollAdditionController@voidPayrollAddDed');
Route::post('undovoidPayrollAddDed','PayrollAdditionController@undovoidPayrollAddDed');
Route::post('rejectPayrollAddDed','PayrollAdditionController@rejectPayrollAddDed');

Route::post('payrollAddDedForwardAction','PayrollAdditionController@payrollAddDedForwardAction');
Route::post('payrollAddDedBackwardAction','PayrollAdditionController@payrollAddDedBackwardAction');
//----------------------------End Payroll Addition---------------------------- 

//----------------------------Production Starts-----------------------------
//----------------------------BOM Starts-----------------------------
Route::get('/bom','BomController@index');
Route::delete('/bomlist','BomController@bomlist');
Route::post('saveBom','BomController@store');
Route::post('saveChildBom','BomController@saveChildBom');
Route::get('/showBom/{id}','BomController@showBom');
Route::get('/showChBom/{id}','BomController@showChBom');
Route::delete('/showBomDetail/{id}','BomController@showBomDetail');
Route::delete('/showChBomDetail/{id}','BomController@showChBomDetail');
Route::delete('/showChildBom/{id}','BomController@showChildBom');
Route::post('deleteBom','BomController@deleteBom');
//----------------------------BOM Ends-----------------------------

//----------------------------Production Order Starts-----------------------------
Route::get('/prdorder','ProductionOrderController@index');
Route::post('/prdorderlist','ProductionOrderController@prdorderlist');
Route::get('/showPoBom/{id}','ProductionOrderController@showPoBom');
Route::post('/calcComBalance','ProductionOrderController@calcComBalance');
Route::post('savePrdOrder','ProductionOrderController@store');
Route::get('/showPrdOrder/{id}','ProductionOrderController@showPrdOrder');
Route::get('/downloadPrOrder/{id}/{file}','ProductionOrderController@downloadPrOrder');
Route::delete('/showPrdOrderDetail/{id}','ProductionOrderController@showPrdOrderDetail');
Route::post('prdChangeToPending','ProductionOrderController@prdChangeToPending');
Route::post('prdBackToDraft','ProductionOrderController@prdBackToDraft');
Route::post('prdChangeToReady','ProductionOrderController@prdChangeToReady');
Route::post('prdOrderVoid','ProductionOrderController@prdOrderVoid');
Route::post('prdOrderUndoVoid','ProductionOrderController@prdOrderUndoVoid');
Route::post('/calcPrepComBalance','ProductionOrderController@calcPrepComBalance');
Route::post('/getCommodityData','ProductionOrderController@getCommodityData');
Route::post('saveProduction','ProductionOrderController@saveProduction');
Route::post('prdOrderAbort','ProductionOrderController@prdOrderAbort');
Route::post('prdOrderUndoAbort','ProductionOrderController@prdOrderUndoAbort');
Route::post('prdStartProcess','ProductionOrderController@prdStartProcess');
Route::post('prdPauseProcess','ProductionOrderController@prdPauseProcess');
Route::post('prdCompleteProcess','ProductionOrderController@prdCompleteProcess');
Route::delete('/showPrdProcess/{id}','ProductionOrderController@showPrdProcess');
Route::delete('/showPrdDuration/{id}','ProductionOrderController@showPrdDuration');
Route::post('prdBackToProduction','ProductionOrderController@prdBackToProduction');
Route::post('submitExport','ProductionOrderController@submitExport');
Route::post('submitReject','ProductionOrderController@submitReject');
Route::post('submitWastage','ProductionOrderController@submitWastage');
Route::post('prdCompleteOutput','ProductionOrderController@prdCompleteOutput');
Route::delete('/showExportData/{id}','ProductionOrderController@showExportData');
Route::delete('/showRejectData/{id}','ProductionOrderController@showRejectData');
Route::delete('/showWastageData/{id}','ProductionOrderController@showWastageData');
Route::post('prdBackToPending','ProductionOrderController@prdBackToPending');
Route::post('saveRatio','ProductionOrderController@saveRatio');
Route::post('prdBackToCloseProduction','ProductionOrderController@prdBackToCloseProduction');
Route::post('verifyProduction','ProductionOrderController@verifyProduction');
Route::post('prdBackToProductionVer','ProductionOrderController@prdBackToProductionVer');
Route::post('completeProductions','ProductionOrderController@completeProductions');
Route::post('prdCompleteOrderVoid','ProductionOrderController@prdCompleteOrderVoid');
Route::post('compPrdOrderUndoVoid','ProductionOrderController@compPrdOrderUndoVoid');
Route::post('prdChangeToReview','ProductionOrderController@prdChangeToReview');
Route::post('prdBackToReady','ProductionOrderController@prdBackToReady');
Route::post('approveProduction','ProductionOrderController@approveProduction');
Route::post('prdBackToVerify','ProductionOrderController@prdBackToVerify');
//----------------------------Production Order Ends-----------------------

//----------------------------Production Order Starts---------------------
Route::get('/prdcost','ProductionCostController@index');
Route::post('/showPrdCommodity','ProductionCostController@showPrdCommodity');
Route::post('/getPrdCostCommData','ProductionCostController@getPrdCostCommData');
Route::post('/getCommtDateDiff','ProductionCostController@getCommtDateDiff');
Route::post('/getPrdExpCostCommData','ProductionCostController@getPrdExpCostCommData');
//----------------------------Production Order Ends-----------------------

//----------------------------Production Ends-----------------------------

//----------------------------INVENTORY-----------------------------

//--------------------------Start Commodity Beginning---------------
Route::get('/commoditybeg','CommodityController@index');
Route::delete('/commbeglist/{fy}','CommodityController@commbeglist');
Route::delete('/cuscommbeglist/{fy}','CommodityController@cuscommbeglist');
Route::post('saveCommodityBeg','CommodityController@store');
Route::get('/showCommBeg/{id}','CommodityController@showCommBeg');
Route::delete('/showOriginData/{id}','CommodityController@showOriginData');
Route::post('/doneCommCount','CommodityController@doneCommCount');
Route::post('/commentCommCount','CommodityController@commentCommCount');
Route::post('/verifyCommCount','CommodityController@verifyCommCount');
Route::post('/postCommCount','CommodityController@postCommCount');
Route::get('/commbegnote/{id}','CommodityController@commBegNote');

Route::post('fetchEndingBalance','CommodityController@fetchEndingBalance');
Route::post('saveCommEnding','CommodityController@saveCommEnding');
Route::get('/showCommEnd/{id}','CommodityController@showCommEnd');
Route::post('/showCommEnding','CommodityController@showCommEnding');
Route::post('endingForwardAction','CommodityController@endingForwardAction');
Route::post('endingBackwardAction','CommodityController@endingBackwardAction');

Route::post('/fetchitemprop','CommodityController@fetchitemprop');
Route::post('saveGoodsBeg','CommodityController@saveGoodsBeg');
//--------------------------End Commodity Beginning---------------

//--------------------------Start Commodity StockBalance-------------
Route::get('/comstockbalance','CommodityStockBalance@index');
Route::delete('/combalancelist','CommodityStockBalance@comStockBalanceData');
Route::delete('/cuscombalancelist','CommodityStockBalance@cusComStockBalanceData');
Route::get('/showComStockBalance/{id}/{cusid}','CommodityStockBalance@showComStockBalance');
Route::delete('/showComStockBalanceDetail/{id}/{cusid}','CommodityStockBalance@showComStockBalanceDetail');
Route::delete('/showProductionQnt/{comm}/{str}/{flrmap}/{commtype}/{grade}/{prctype}/{crpyr}/{uomid}/{cusid}','CommodityStockBalance@showProductionQnt');
Route::delete('/showDispatchData/{comm}/{str}/{flrmap}/{commtype}/{grade}/{prctype}/{crpyr}/{uomid}/{cusid}','CommodityStockBalance@showDispatchData');
//--------------------------End Commodity StockBalance-------------

//----------------------Receiving Route Start----------------------
Route::get('/receiving','ReceivingController@index');
Route::delete('/holdtable/{fy}','ReceivingController@showHoldData');
// Route::delete('/receivingtable/{fy}','ReceivingController@showRecevingData');
Route::delete('/receivingtable/{ct}/{fy}','ReceivingController@showRecevingData');
Route::get('/showSupplierInfo/{nm}','ReceivingController@showSupplierInfoCon');
Route::delete('/showMRCInfo/{nm}','ReceivingController@showMRCSCon');
Route::get('/showItemInfo/{nm}','ReceivingController@showItemInfoCon');
Route::post('saveReceiving','ReceivingController@store');
Route::post('saveHolding','ReceivingController@holdstore');
Route::get('/getHoldNumber','ReceivingController@getHoldNumberData');
Route::get('/holdedit/{id}','ReceivingController@editHold');
Route::get('/recevingedit/{id}','ReceivingController@editReceiving');
Route::delete('/showholDetail/{id}','ReceivingController@showHoldDetailData');
Route::delete('/showrReceivingDetail/{id}','ReceivingController@showReceivingDetailData');
Route::post('savenewhold','ReceivingController@storeNewholdItem');
Route::post('savenewitemrec','ReceivingController@storeNewRecItem');
Route::get('/holditemedit/{id}','ReceivingController@editHoldItem');
Route::get('/recitemedit/{id}','ReceivingController@editReceivingItem');
Route::delete('/deleteholditemdata/{id}', 'ReceivingController@deleteHoldItem');
Route::delete('/deleteholddataw/{id}', 'ReceivingController@deleteHoldData');
Route::get('/getNewHoldNumber','ReceivingController@getNewHoldNumberData');
Route::get('/showHoldData/{nm}','ReceivingController@showHoldDataCon');
Route::get('/showRecDataRec/{nm}','ReceivingController@showRecDataCon');
Route::get('/showRecDataRecSettle/{nm}/{sids}','ReceivingController@showRecDataConSett');
Route::get('/showRecDataRecUnSettle/{nm}/{sids}','ReceivingController@showRecDataConUnSett');
Route::get('/getWithNumber','ReceivingController@getWitholdNumberData');

Route::post('saveHoldRec','ReceivingController@saveHoldReceiving');
Route::delete('/deletereceivingitemdata/{id}', 'ReceivingController@deleteReceivingItem');
Route::delete('/showrecDetail/{id}','ReceivingController@showRecDetailData');
Route::post('/checkStatus','ReceivingController@updateChecked');
Route::post('/pendingStatus','ReceivingController@updatePending');
Route::post('/confirmStatus','ReceivingController@updateConfimed');
Route::post('/voidReceiving','ReceivingController@receivingVoid');
Route::post('/voidRec','ReceivingController@receivingRecVoid');
Route::post('/undoVoid','ReceivingController@undoReceivingVoid');
Route::post('/undoVd','ReceivingController@undoRecVoid');
Route::delete('/getUOMS/{id}','ReceivingController@getAllUoms');
Route::delete('/getUOMAmount/{id}/{nid}','ReceivingController@getConversionAmount');
Route::post('/hideReceiving','ReceivingController@updateHide');
Route::post('/showReceiving','ReceivingController@updateShow');

Route::delete('/showwitholdDt/{cid}/{trd}','ReceivingController@showWitholdingDataTable');
Route::delete('/showwitholdDtsep/{cid}/{trd}','ReceivingController@showWitholdingDataTableSep');
Route::delete('/showwitholdDtSelected/{cid}/{trd}/{ids}','ReceivingController@showWitholdingDataTableSepSelected');
Route::post('settleWitholdFn','ReceivingController@SettleWitholdCon');
Route::get('/showRecDataRecSep/{nm}','ReceivingController@showRecDataConSep');
Route::post('sepsettleWitholdFn','ReceivingController@SettleWitholdConSep');
Route::post('/unsettleWithold','ReceivingController@unsettledControl');

Route::delete('/showModelsRec/{nm}','ReceivingController@showModelsConRec');
Route::get('/showSerialNmRec/{cmn}/{nid}','ReceivingController@showSerialNumbersRec');
Route::post('addSerialnumbersRec','ReceivingController@addSerialnumberConRec');
Route::get('/serialnumbereditRec/{id}','ReceivingController@editSerialNumberConRec');
Route::delete('/serialdeleteRec/{id}', 'ReceivingController@deleteSerialNumRec');

Route::get('/showSerialNmRecStatic/{cmn}/{nid}','ReceivingController@showSerialNumbersRecStatic');
Route::post('addSerialnumbersRecStatic','ReceivingController@addSerialnumberConRecStatic');
Route::get('/serialnumbereditRecStatic/{id}','ReceivingController@editSerialNumberConRecStatic');
Route::delete('/serialdeleteRecStatic/{id}', 'ReceivingController@deleteSerialNumRecStatic');

Route::delete('/receivingtablefy/{fy}','ReceivingController@receivingtablefy');
Route::delete('/holdtablefy/{fy}','ReceivingController@holdtablefy');

Route::post('/getPoData','ReceivingController@getPoData');
Route::post('/getPoNumberList','ReceivingController@getPoNumberList');
Route::post('/calcReqAmount','ReceivingController@calcReqAmount');
Route::post('saveProcReceiving','ReceivingController@saveProcReceiving');
Route::delete('/showRecCommodity/{id}','ReceivingController@showRecCommodity');
Route::post('recBackToDraft','ReceivingController@recBackToDraft');
Route::post('recBackToPending','ReceivingController@recBackToPending');
Route::get('/downloadGrvDoc/{id}/{file}','ReceivingController@downloadGrvDoc');
Route::delete('/showReturnedCommodity/{id}','ReceivingController@showReturnedCommodity');

Route::post('/countReceivingStatus','ReceivingController@countReceivingStatus');
Route::post('receivingForwardAction','ReceivingController@receivingForwardAction');
Route::post('receivingBackwardAction','ReceivingController@receivingBackwardAction');

Route::post('/fetchReceivingRefDoc','ReceivingController@fetchReceivingRefDoc');
Route::post('/fetchReceivingRefData','ReceivingController@fetchReceivingRefData');
Route::post('/fetchItemInfo','ReceivingController@fetchItemInfo');
Route::post('/uploadDocument','ReceivingController@uploadDocument');
Route::post('/fetchReceivingDoc','ReceivingController@fetchReceivingDoc');
Route::post('/showDocumentData/{recid}','ReceivingController@showDocumentData');

Route::post('saveBatchAndSerial','ReceivingController@saveBatchAndSerial');
Route::post('getBatchAndSerial','ReceivingController@getBatchAndSerial');
//----------------------Receiving Route Ends----------------------

//----------------------Stock balance route starts----------------------
Route::get('/stockbalance','StockBalanceController@index');
Route::delete('/stockbalancedata','StockBalanceController@showStockBalanceData');
Route::delete('/showStockDetail/{id}','StockBalanceController@showStockDetailData');
Route::delete('/showdeliveredqty/{itid}/{stid}','StockBalanceController@showDeliveredQty');
//----------------------Stock balance route ends----------------------

//----------------------Store Requistion Starts----------------------
Route::get('/requisition','StoreRequisition@index');
Route::get('/getreqnumber','StoreRequisition@getRequisitionNumber');
Route::delete('/getstoreItem/{id}','StoreRequisition@getstoreItem');
Route::delete('/getItemBalance/{id}','StoreRequisition@getItemQuantity');
Route::delete('/getEditItemBalance/{id}','StoreRequisition@getItemEditQuantity');
Route::post('saveRequisition','StoreRequisition@store');
Route::delete('/requisitiondata/{ct}/{fy}','StoreRequisition@showRequisitionData');
Route::delete('/reqdata/{fy}','StoreRequisition@reqdata');
Route::get('/requisitionedit/{id}','StoreRequisition@editRequisition');
Route::delete('/showrRequisitionDetail/{id}','StoreRequisition@showRequisitionDetailData');
Route::get('/reqitemedit/{id}','StoreRequisition@editRequisitionItem');
Route::post('savenewReqItem','StoreRequisition@storeNewReqItem');
Route::delete('/deleteReqItem/{id}','StoreRequisition@deleteRequisitionItem');
Route::delete('/deleteReqData/{id}','StoreRequisition@deleteRequisitionData');
Route::get('/showReqData/{id}','StoreRequisition@showReqDataCon');
Route::delete('/showReqDetail/{id}','StoreRequisition@showReqDetailData');
Route::delete('/requisitiondatafy/{fy}','StoreRequisition@requisitiondatafy');
Route::post('syncDynamicTable','StoreRequisition@syncDynamicTable');//newly added
Route::post('undorequistion','StoreRequisition@undorequistion');//newly added

Route::post('/calcReqBalance','StoreRequisition@calcReqBalance');
Route::post('/calcReqStBalance','StoreRequisition@calcReqStBalance');
Route::post('/storeComm','StoreRequisition@storeComm');
Route::delete('/showCommData/{id}','StoreRequisition@showCommData');
Route::post('/pendingReqStatus','StoreRequisition@pendingReqStatus');
Route::post('/backToDraftReq','StoreRequisition@backToDraftReq');
Route::post('/approveCommReq','StoreRequisition@approveCommReq');
Route::post('reqBackToPending','StoreRequisition@reqBackToPending');
Route::post('/reqRejectComm','StoreRequisition@reqRejectComm');
Route::delete('/reqVoidComm/{id}','StoreRequisition@reqVoidComm');
Route::post('reqUndoVoidComm','StoreRequisition@reqUndoVoidComm');
Route::post('/issReqComm','StoreRequisition@issueRequisitionComm');

Route::post('/fetchDispatchInfo','StoreRequisition@fetchDispatchInfo');
Route::post('/calcRemAmnt','StoreRequisition@calcRemAmnt');
Route::post('/saveDispatchData','StoreRequisition@saveDispatchData');
Route::delete('/showDispatchListData/{id}','StoreRequisition@showDispatchData');
Route::post('/fetchDispatchData','StoreRequisition@fetchDispatchData');
Route::delete('/showDispatchDetailData/{id}','StoreRequisition@showDispatchDetailData');
Route::post('/voidDispatchData','StoreRequisition@voidDispatchData');
Route::post('/undoVoidDispatchData','StoreRequisition@undoVoidDispatchData');
Route::delete('/showInfoDispatchData/{id}','StoreRequisition@showInfoDispatchData');
Route::post('/verifyDispatch','StoreRequisition@verifyDispatch');
Route::post('/BacktoPendingDispatch','StoreRequisition@BacktoPendingDispatch');
Route::post('/approveDispatch','StoreRequisition@approveDispatch');
Route::post('/verifyCommReq','StoreRequisition@verifyCommReq');
Route::post('/backToVerifyReq','StoreRequisition@backToVerifyReq');
Route::post('reqChangeToReview','StoreRequisition@reqChangeToReview');
Route::post('/backToReviewReq','StoreRequisition@backToReviewReq');

Route::post('/fetchitembalance','StoreRequisition@fetchitembalance');
Route::post('/countRequisitionStatus','StoreRequisition@countRequisitionStatus');
Route::post('requisitionForwardAction','StoreRequisition@requisitionForwardAction');
Route::post('requisitionBackwardAction','StoreRequisition@requisitionBackwardAction');
//----------------------Store Requistion Ends----------------------

//----------------------Approver route starts----------------------
Route::get('/approver','ApproverController@index');
Route::delete('/requisitiondataapp','ApproverController@showRequisitionDataApp');
Route::get('/showReqDataapp/{id}','ApproverController@showReqDataConApp');
Route::delete('/showReqDetailapp/{id}','ApproverController@showReqDetailDataApp');
Route::post('/approveReq','ApproverController@approveRequisition');
Route::post('/commentReq','ApproverController@commentRequisition');
Route::post('/rejReq','ApproverController@rejectRequisition');

Route::delete('/transferDataShow','ApproverController@showTransferDataApp');
Route::get('/showTrAppData/{id}','ApproverController@showTrDataConApp');
Route::delete('/showTrAppDetail/{id}','ApproverController@showTrAppDetailData');
Route::post('/approveTr','ApproverController@approveTransfer');
Route::post('/commentTr','ApproverController@commentTransfer');
Route::post('/rejTr','ApproverController@rejectTransfer');

Route::delete('/requisitiondataappfy/{fy}','ApproverController@requisitiondataappfy');
Route::delete('/transferDataShowfy/{fy}','ApproverController@transferDataShowfy');
//--------------------Approver route ends----------------------

//--------------------Issue route starts----------------------
Route::get('/issue','IssueController@index');
Route::delete('/issuedataapp','IssueController@showIssueDataApp');
Route::delete('/issuedatastiv','IssueController@showIssueDataStiv');
Route::delete('/showDetailiss/{id}','IssueController@showIssueDetailDataIss');
Route::get('/showReqDataiss/{id}','IssueController@showReqDataConIss');
Route::delete('/issuedataiss','IssueController@showRequisitionDataIss');
Route::get('/showReqDataapproving/{id}','IssueController@showReqDataConApproving');
Route::post('/issReq','IssueController@issueRequisition');

Route::delete('/transferIssDataShow','IssueController@showTransferIssDataApp');
Route::get('/showTrIssData/{id}','IssueController@showTrIssDataCon');
Route::delete('/showTrIssAppDetail/{id}','IssueController@showTrIssAppDetailData');
Route::post('/issTr','IssueController@issueTransfer');
Route::get('/showTrIssueUser/{str}','IssueController@showIssueUser');

Route::delete('/getIssueSerNum/{itid}/{stid}/{serid}','IssueController@getIssueSerNum');
Route::delete('/getIssueSerNumSl/{itid}/{stid}/{serid}','IssueController@getIssueSerNumSl');
Route::post('/saveserialnum','IssueController@saveIssueSerialnumber');
Route::get('/showTransferSerialNum/{str}','IssueController@showTransferSerialNum');

Route::delete('/issuedataissfy/{fy}','IssueController@issuedataissfy');
Route::delete('/issuedataappfy/{fy}','IssueController@issuedataappfy');
Route::delete('/issuedatastivfy/{fy}','IssueController@issuedatastivfy');
Route::delete('/transferIssDataShowfy/{fy}','IssueController@transferIssDataShowfy');
Route::post('/receiveTr','IssueController@receiveTransfer');
//--------------------Issue route ends-----------------------

//--------------------Adjustment route starts----------------
Route::get('/adjustment','AdjustmentController@index');
Route::get('/getadjnumber','AdjustmentController@getAdjustmentNumber');
Route::get('/getadjstoreItem/{id}','AdjustmentController@getAdjustmentStoreItem');
Route::delete('/getAdjItemBalance/{id}','AdjustmentController@getAdjItemQuantity');
Route::post('saveAdjustment','AdjustmentController@store');
Route::delete('/adjustmentdata','AdjustmentController@showAdjustmentData');
Route::delete('/showAdjDetailapp/{id}','AdjustmentController@showAdjDetailDataApp');
Route::get('/showAdjDataHeader/{id}','AdjustmentController@showAdjDataHeaderCon');
Route::get('/adjustmentedit/{id}','AdjustmentController@editAdjustmentCon');
Route::get('/serialnumbereditAdj/{id}','AdjustmentController@editSerialNumberConAdj');
Route::post('addSerialnumbersAdj','AdjustmentController@addSerialnumberConAdj');
Route::get('/showSerialNmAdj/{cmn}/{nid}','AdjustmentController@showSerialNumbersAdj');
Route::delete('/serialdeleteAdj/{id}', 'AdjustmentController@deleteSerialNumAdj');
Route::delete('/adjustmentdatafy/{fy}','AdjustmentController@adjustmentdatafy');
Route::post('syncDynamicTablead','AdjustmentController@syncDynamicTable');//newly added
Route::get('/showRecDataAdj/{nm}','AdjustmentController@showRecDataCon');//newly added
Route::post('/checkStatusAdj','AdjustmentController@updateChecked');//newly added
Route::post('/confirmStatusAdj','AdjustmentController@updateConfimed');//newly added
Route::post('/pendingStatusAdj','AdjustmentController@updatePending');//newly added
Route::post('/voidAdjustment','AdjustmentController@adjustmentVoid');//newly added
Route::post('/voidAdj','AdjustmentController@adjustmentPenVoid');//newly added
Route::post('/undoAdjVoid','AdjustmentController@undoAdjustmentVoid');//newly added
Route::post('/undoPenVoid','AdjustmentController@undoRecVoid');//newly added

Route::post('storeadj','AdjustmentController@storeadj');
Route::delete('/commadjlist/{fy}','AdjustmentController@commadjlist');
Route::delete('/cuscommadjlist/{fy}','AdjustmentController@cuscommadjlist');
Route::get('/showAdjData/{id}','AdjustmentController@showAdjData');
Route::delete('/showAdjDetailData/{id}','AdjustmentController@showAdjDetailData');
Route::post('/calcAdjBalance','AdjustmentController@calcAdjBalance');
Route::post('/voidCommAdj','AdjustmentController@voidCommAdj');
Route::post('/undoVoidCommAdj','AdjustmentController@undoVoidCommAdj');
Route::post('adjForwardAction','AdjustmentController@adjForwardAction');
Route::post('adjBackwardAction','AdjustmentController@adjBackwardAction');
Route::get('/adjcomm/{id}','AdjController@adjcomm');
//-----------------Adjustment route ends---------------

//----------------Transfer route starts---------------
Route::get('/transfer','TransferController@index');
Route::post('/transferdata','TransferController@showTransferData');
Route::get('/gettransfernumber','TransferController@getTransferNumber');
Route::post('saveTransfer','TransferController@store');
Route::get('/showTrData/{id}','TransferController@showTrDataCon');
Route::delete('/showTrDetail/{id}','TransferController@showTrDetailData');
Route::get('/transferedit/{id}','TransferController@editTransferCon');
Route::get('/transferstatus/{id}','TransferController@editTransferConStatus');
Route::delete('/showrtransferDetail/{id}','TransferController@showTransferDetailData');
Route::delete('/getTransferStoreItem/{id}','TransferController@getTransferStoreItemCon');
Route::post('savenewTransferItem','TransferController@storeNewTrItem');
Route::get('/transferitemedit/{id}','TransferController@editTransferItem');
Route::post('getEditTrItemBalance','TransferController@getTrItemEditQuantity');
Route::delete('/deleteTrItem/{id}', 'TransferController@deleteTransferItem');
Route::delete('/deleteTrData/{id}','TransferController@deleteTransferData');
Route::delete('/getstoreItemTr/{id}','TransferController@getstoreItemCon');
Route::delete('/transferdatafy/{fy}','TransferController@showTransferDataFy');
Route::post('syncDynamicTabletr','TransferController@syncDynamicTable');//newly added
Route::post('undotransfer','TransferController@undotransfer');//newly added
Route::post('/calcTrnBalance','TransferController@calcTrnBalance');
Route::post('approveTransfer','TransferController@approveTransfer');
Route::post('/pendingTransfer','TransferController@pendingTransfer');
Route::post('/backToDraftTrn','TransferController@backToDraftTrn');
Route::post('/verifyTransfer','TransferController@verifyTransfer');
Route::post('trnBackToPending','TransferController@trnBackToPending');
Route::post('/backToVerifyTrn','TransferController@backToVerifyTrn');
//-------------Transfer route ends---------------

//-------------Begining route starts-------------
Route::get('/begining','BeginingController@index');
Route::delete('/beginingDataApp','BeginingController@showBeginingData');
Route::get('/getbgnumber','BeginingController@getBgNumber');
Route::post('savebg','BeginingController@store');
Route::get('/beginingedit/{id}','BeginingController@editBegining');
Route::post('/startCount','BeginingController@startCountingCon');
Route::get('/showBgData/{id}','BeginingController@showBgHeader');
Route::delete('/showDetailBg/{id}','BeginingController@showBeginingDetailData');
Route::post('syncItem','BeginingController@syncBgItems');
Route::get('updateQ/{id}/{data}','BeginingController@quantityUpdate');
Route::get('updateUp/{id}/{data}','BeginingController@unitcostUpdate');
Route::post('/doneCount','BeginingController@countDone');
Route::post('/verifyCount','BeginingController@countVerify');
Route::post('/commentCount','BeginingController@countComment');
Route::post('/postCount','BeginingController@countPost');
Route::delete('/showDetailBgPosted/{id}','BeginingController@showBeginingDetailPostedData');
Route::delete('/showAdjData/{id}','BeginingController@showAdjustmentData');
Route::post('syncCost','BeginingController@syncBgCost');
Route::get('/showBgItemInfo/{nm}/{strid}/{headerid}','BeginingController@showBgItemInfoCon');
Route::post('/postSingleItem','BeginingController@postItem');
Route::get('/editPostedItem/{id}','BeginingController@editSingleItem');
Route::post('/editPostedSingleItem','BeginingController@editPostedSingleItem');
Route::post('/deletePostedItem','BeginingController@deletePostedSingleItem');

Route::get('/showSerialNumberBg/{nm}','BeginingController@showSerialNumberConBg');
Route::post('addSerialnumbersBg','BeginingController@addSerialnumberConBg');
Route::delete('/showModels/{nm}','BeginingController@showModelsCon');
Route::get('/showSerialNmBg/{id}/{nid}/{trtype}','BeginingController@showSerialNumbersBg');
Route::get('/serialnumbereditBg/{id}','BeginingController@editSerialNumberConBg');
Route::delete('/serialdeleteBg/{id}', 'BeginingController@deleteSerialNumBg');

Route::delete('/showBeginingDataFy/{fy}', 'BeginingController@showBeginingDataFy');
//--------------Begining route ends----------

//-------------Dead Stock Route Starts--------
Route::get('/deadstock','DeadStockController@index');
Route::get('/getDeadStockNum','DeadStockController@getDeadStockNumber');
Route::post('saveDeadStock','DeadStockController@store');
Route::delete('/deadstocktable','DeadStockController@showDeadStockRecevingData');
Route::get('/deadstockedit/{id}','DeadStockController@editDeadStock');
Route::delete('/showrDeadStockDetail/{id}','DeadStockController@showDeadStockDetailData');
Route::get('/deadstockitemedit/{id}','DeadStockController@editDeadStockItem');
Route::delete('/getDeadStockUOM/{id}','DeadStockController@getAllDeadStockUoms');
Route::delete('/getDeadStockUOMAmount/{id}/{nid}','DeadStockController@getDeadStockConversionAmount');
Route::post('savenewdeadstockitem','DeadStockController@storeNewDeadStockItems');
Route::post('savenewdeadstockitempen','DeadStockController@storeNewDeadStockItemsPen');
Route::delete('/deletedeadstockitemdata/{id}','DeadStockController@deleteDeadStockItem');\
Route::delete('/deletedeadstockitemdatapen/{id}','DeadStockController@deleteDeadStockItemPen');
Route::get('/showDeadStockData/{nm}','DeadStockController@showDeadStockDataCon');
Route::delete('/showDeadStockDetail/{id}','DeadStockController@showDeadStockDetailDataCon');
Route::post('/voidDeadStockReceiving','DeadStockController@receivingDeadStockVoid');
Route::post('/voidDeadStockReceivingPen','DeadStockController@receivingDeadStockVoidPen');
Route::get('/showDeadStockRec/{nm}','DeadStockController@showDeadStockRecCon');
Route::post('/undoDeadStockVoid','DeadStockController@undoDeadStockVoidCon');
Route::post('/undoDeadStockVoidPen','DeadStockController@undoDeadStockVoidPen');
Route::delete('/deadstockbalance','DeadStockController@showDeadStockBalanceData');
Route::delete('/showDeadStockDetailInfo/{id}','DeadStockController@showDeadStockDetailDataInfo');
Route::get('/showdsItemInfo/{nm}','DeadStockController@showDeadStockItemCon');
Route::delete('/getDsItemBalance/{id}','DeadStockController@getDeadStockItemQuantity');
Route::post('/updateSellingPr','DeadStockController@updateSellingPrice');
Route::post('/confirmHandInStatus','DeadStockController@updateHandInConfimed');
//-------------------route added by red----------------------------
Route::get('/deadstocksale','DeadStockController@deadstocksale');
Route::get('/getSalesDeadStockNum','DeadStockController@getSalesDeadStockNumber');
Route::get('/showItemInfodead/{itemid}/{storeval}','DeadStockController@showItemInfodead');
Route::delete('/saleUOMSdead/{id}','DeadStockController@saleUOMSdead');
Route::post('/deadstocksavesale','DeadStockController@deadstocksavesale');
Route::get('/deadstocksalelist','DeadStockController@deadstocksalelist');
Route::get('/deadshowSale/{id}','DeadStockController@deadshowSale');
Route::get('/deadsalechildsalelist/{id}','DeadStockController@deadsalechildsalelist');
Route::get('/deadshowItemInfo/{nm}/{storeid}','DeadStockController@deadshowItemInfo');
Route::delete('/deadgetsaleUOMAmount/{id}/{nid}','DeadStockController@getConversionAmount');
Route::post('/deadsavesaleitem','DeadStockController@deadsavesaleitem');
Route::post('/deadsavesaleitempen','DeadStockController@deadsavesaleitempen');
Route::get('/deadshowsaleItem/{id}','DeadStockController@deadshowsaleItem');
Route::delete('/deadsaleholddelete/{id}','DeadStockController@deadsaleholddelete');
Route::delete('/deadcheckedsale/{id}','DeadStockController@deadcheckedsale');
Route::post('/confirmpullout','DeadStockController@confirmPullOut');

Route::delete('/getItemsByDsStore','DeadStockController@getItemsByDsStore');
Route::delete('/getItemsByStore/{sid}','DeadStockController@getItemsByStore');
Route::post('syncDynamicTableds','DeadStockController@syncDynamicTable');//newly added
Route::post('syncDynamicTabledspo','DeadStockController@syncDynamicTablepo');//newly added

Route::get('/dspo/{id}','DsReportController@index');
Route::get('/dshi/{id}','DsReportController@indexhi');

Route::get('/dsgenpo','DsPoHiReportController@dspoReport');
Route::delete('/dspogenreport/{from}/{to}/{store}/{paymenttype}/{group}/{potype}','DsPoHiReportController@DSPOReportCon');//newly added

Route::get('/dsgenhi','DsPoHiReportController@dshiReport');
Route::delete('/dshigenreport/{from}/{to}/{store}/{paymenttype}/{hitype}','DsPoHiReportController@DSHIReportCon');//newly added
//----------------End of route added by red----------------------

//---------------Start DS StockIN-----------------------------
Route::get('/dstockin','DStockInController@index');
Route::post('/getDStockInData/{fy}','DStockInController@getDStockInData');
Route::post('/countDStockInStatus','DStockInController@countDStockInStatus');
Route::post('/calcDSRemBalance','DStockInController@calcDSRemBalance');
Route::post('/saveDStockIn','DStockInController@store');
Route::post('/fetchDStockInData','DStockInController@fetchDStockInData');
Route::delete('/getDStockInDetailData/{id}','DStockInController@getDStockInDetailData');
Route::post('/voidDStockInData','DStockInController@voidDStockInData');
Route::post('/undoVoidDStockIn','DStockInController@undoVoidDStockIn');
Route::post('dstockInForwardAction','DStockInController@dstockInForwardAction');
Route::post('dstockInBackwardAction','DStockInController@dstockInBackwardAction');
//--------------End DS StockIN-------------------------------

//---------------Start DS StockOUT-----------------------------
Route::get('/dstockout','DStockOutController@index');
Route::post('/getDStockOutData/{fy}','DStockOutController@getDStockOutData');
Route::post('/countDStockOutStatus','DStockOutController@countDStockOutStatus');
Route::post('/calcDStockOutRemBalance','DStockOutController@calcDStockOutRemBalance');
Route::post('/saveDStockOut','DStockOutController@store');
Route::post('/fetchDStockOutData','DStockOutController@fetchDStockOutData');
Route::delete('/getDStockOutDetailData/{id}','DStockOutController@getDStockOutDetailData');
Route::post('/voidDStockOutData','DStockOutController@voidDStockOutData');
Route::post('/undoVoidDStockOut','DStockOutController@undoVoidDStockOut');
Route::post('dstockOutForwardAction','DStockOutController@dstockOutForwardAction');
Route::post('dstockOutBackwardAction','DStockOutController@dstockOutBackwardAction');
//---------------End DS StockOUT-----------------------------

//---------------Start DS Balance-----------------------------
Route::get('/dstockbalance','DSBalanceController@index');
Route::post('/getDSBalanceData','DSBalanceController@getDSBalanceData');
Route::post('/showDStockDetail/{id}','DSBalanceController@showDStockDetail');
Route::post('/showAllocationData','DSBalanceController@showAllocationData');
Route::post('/updateItemPrice','DSBalanceController@updateItemPrice');
Route::get('/showItemData/{id}','DSBalanceController@showItemData');
//---------------End DS Balance-----------------------------

//---------------Start Commodity Report--------------------------

//-----Receiving report start------
Route::get('/receivingrep','CommodityReportController@recrepindex');
Route::post('receivingReport','CommodityReportController@receivingReport');
Route::post('receivingDataFetch','CommodityReportController@receivingDataFetch');
//-----Receiving report end------

//------Stock balalnce report start-----
Route::get('/stockbalancerep','CommodityReportController@stockbalancerepindex');
Route::post('stockBalanceReport','CommodityReportController@stockBalanceReport');
Route::post('stockBalanceDataFetch','CommodityReportController@stockBalanceDataFetch');
Route::post('fetchAllocationData','CommodityReportController@fetchAllocationData');
//-----Stock balance report end------

//------Stock balalnce value start-----
Route::get('/stockvaluerep','CommodityReportController@stockvaluerepindex');
Route::post('stockValueReport','CommodityReportController@stockValueReport');
Route::post('stockValueDataFetch','CommodityReportController@stockValueDataFetch');
Route::post('fetchValueAllocData','CommodityReportController@fetchValueAllocData');
//-----Stock balance value end------

//------Stock cost history start-----
Route::get('/stockcosthistory','CommodityReportController@stockcosthisotyrepindex');
Route::post('stockCostHistoryReport','CommodityReportController@stockCostHistoryReport');
Route::post('stockCostHistoryDataFetch','CommodityReportController@stockCostHistoryDataFetch');
//------Stock cost history end-----

//------Requisition & Issue Start-----
Route::get('/reqissuerep','CommodityReportController@reqissueindex');
Route::post('requisitionIssueReport','CommodityReportController@requisitionIssueReport');
Route::post('reqIssueDataFetch','CommodityReportController@reqIssueDataFetch');
Route::delete('/showReportDispatchData/{id}','CommodityReportController@showReportDispatchData');
//------Requisition & Issue End-----

//------Stock Movement Start-------
Route::get('/stockmovement','CommodityReportController@stockmovementindex');
Route::post('stockMovementReport','CommodityReportController@stockMovementReport');
Route::post('stockMovementDataFetch','CommodityReportController@stockMovementDataFetch');
//------Stock Movement End-------
//---------------End Commodity Report----------------------------

//---------------Ending Controller Starts------------------------
Route::get('/ending','EndingController@index');
Route::post('saveend','EndingController@store');
Route::delete('/endingDataApp','EndingController@showEndingData');
Route::get('/endingedit/{id}','EndingController@editEnding');
Route::post('/startEndingCount','EndingController@startEndingCountingCon');
Route::get('/showEndingData/{id}','EndingController@showEndingHeader');
Route::get('/showResEndingData/{id}','EndingController@startResumeEndingCountingCon');
Route::delete('/showDetailEnding/{id}','EndingController@showEndingDetailData');
Route::get('updateEndingUp/{id}/{data}','EndingController@unitcostEndingUpdate');
Route::get('updateEndingQ/{id}/{data}','EndingController@quantityEndingUpdate');
Route::post('/doneEndCount','EndingController@countEndDone');
Route::post('/verifyEndCount','EndingController@countEndVerify');
Route::post('/postEndCount','EndingController@countEndPost');
Route::post('syncEndItem','EndingController@syncBgEndItems');
Route::post('/commentEndCount','EndingController@countEndComment');
Route::get('/showSerialNumberEnding/{nm}','EndingController@showSerialNumberConEnding');
Route::get('/showSerialNmEnding/{id}/{nid}','EndingController@showSerialNumbersEnding');
Route::post('addSerialnumbersEnding','EndingController@addSerialnumberConEnding');
Route::get('/showEndData/{id}','EndingController@showEndHeader');
Route::delete('/showDetailEndPosted/{id}','EndingController@showEndingDetailPostedData');

Route::delete('/showEndingDataFy/{fy}','EndingController@showEndingDataFy');
//-----------------Ending controller ends-------------------

//-------------Ds Begining route starts-------------
Route::get('/dsbegining','DsBeginingController@index');
Route::delete('/dsbeginingDataApp','DsBeginingController@showBeginingData');
Route::get('/getdsbgnumber','DsBeginingController@getBgNumber');//newly added
Route::post('dssavebg','DsBeginingController@store');
Route::get('/dsbeginingedit/{id}','DsBeginingController@editBegining');
Route::post('/dsstartCount','DsBeginingController@startCountingCon');
Route::get('/dsshowBgData/{id}','DsBeginingController@showBgHeader');
Route::delete('/dsshowDetailBg/{id}','DsBeginingController@showBeginingDetailData');
Route::post('dssyncItem','DsBeginingController@syncBgItems');
Route::get('dsupdateQ/{id}/{data}','DsBeginingController@quantityUpdate');
Route::get('dsupdateUp/{id}/{data}','DsBeginingController@unitcostUpdate');
Route::post('/dsdoneCount','DsBeginingController@countDone');
Route::post('/dsverifyCount','DsBeginingController@countVerify');
Route::post('/dscommentCount','DsBeginingController@countComment');
Route::post('/dspostCount','DsBeginingController@countPost');
Route::delete('/dsshowDetailBgPosted/{id}','DsBeginingController@showBeginingDetailPostedData');
Route::delete('/dsshowAdjData/{id}','DsBeginingController@showAdjustmentData');
Route::post('dssyncCost','DsBeginingController@syncBgCost');
Route::get('/dsshowBgItemInfo/{nm}/{strid}/{headerid}','DsBeginingController@showBgItemInfoCon');
Route::post('/dspostSingleItem','DsBeginingController@postItem');
Route::get('/dseditPostedItem/{id}','DsBeginingController@editSingleItem');
Route::post('/dseditPostedSingleItem','DsBeginingController@editPostedSingleItem');
Route::post('/dsdeletePostedItem','DsBeginingController@deletePostedSingleItem');

Route::get('/dsshowSerialNumberBg/{nm}','DsBeginingController@showSerialNumberConBg');
Route::post('dsaddSerialnumbersBg','DsBeginingController@addSerialnumberConBg');
Route::delete('/dsshowModels/{nm}','DsBeginingController@showModelsCon');
Route::get('/dsshowSerialNmBg/{id}/{nid}/{trtype}','DsBeginingController@showSerialNumbersBg');
Route::get('/dsserialnumbereditBg/{id}','DsBeginingController@editSerialNumberConBg');
Route::delete('/dsserialdeleteBg/{id}', 'DsBeginingController@deleteSerialNumBg');

Route::delete('/dsshowBeginingDataFy/{fy}', 'DsBeginingController@showBeginingDataFy');
//--------------Ds Begining route ends----------

//---------------INVENTORY ENDED-------------------

//---------------Start Logistic--------------------

//---------------Start Dispatch--------------------
Route::get('/dispatch','DispatchController@index');
Route::delete('/getDispatchData/{fy}','DispatchController@getDispatchData');
Route::post('/calcRemTransfer','DispatchController@calcRemTransfer');
Route::post('/calcRemSales','DispatchController@calcRemSales');
Route::post('/saveDispatchTransfer','DispatchController@store');
Route::post('/fetchTransferDispData','DispatchController@fetchTransferDispData');
Route::delete('/getDispatchDetailData/{id}','DispatchController@getDispatchDetailData');
Route::post('/verifyTransferDispatch','DispatchController@verifyTransferDispatch');
Route::post('/BacktoTrnPendingDispatch','DispatchController@BacktoTrnPendingDispatch');
Route::post('/approveTransferDispatch','DispatchController@approveTransferDispatch');
Route::post('/voidTrnDispatchData','DispatchController@voidTrnDispatchData');
Route::post('/undoVoidTrnDispatchData','DispatchController@undoVoidTrnDispatchData');
Route::post('/pendingTransferDispatch','DispatchController@pendingTransferDispatch');
Route::post('backToDraftTrnDispatch','DispatchController@backToDraftTrnDispatch');
Route::post('/receiveTransferDispatch','DispatchController@receiveTransferDispatch');
Route::get('/disptr/{id}','DispatchController@disptr');
Route::get('/showDisData/{id}/{dtype}','DispatchController@showDisData');
Route::delete('/showSalesDetailData/{id}','DispatchController@showSalesDetailData');

Route::post('/countDispatchStatus','DispatchController@countDispatchStatus');
Route::post('dispatchForwardAction','DispatchController@dispatchForwardAction');
Route::post('dispatchBackwardAction','DispatchController@dispatchBackwardAction');
//---------------End Dispatch--------------------
//---------------End Logistic--------------------

//---------------Start DO--------------------
Route::get('/deliveryorder','DeliveryOrderController@index');
Route::post('/fetchReferenceDoc','DeliveryOrderController@fetchReferenceDoc');
Route::post('/fetchReferenceData','DeliveryOrderController@fetchReferenceData');
//---------------End DO--------------------


//---------------Start finance closing------------------
Route::get('/closing','ClosingController@index');
Route::delete('/closinglist/{fy}','ClosingController@closinglistCon');
Route::delete('/showMrcList/{nm}','ClosingController@showMrcListCon');
Route::get('/showallpr/{mrc}/{pid}','ClosingController@showAllPrices');
Route::post('/getposdata','ClosingController@getposdatacon');
Route::post('/getrevenues','ClosingController@getrevenuescon'); 
Route::delete('/showfiscash/{posid}/{stdate}/{endate}','ClosingController@showfiscash');
Route::delete('/showfiscredit/{posid}/{stdate}/{endate}','ClosingController@showfiscredit');
Route::delete('/showcashmanual/{posid}/{stdate}/{endate}','ClosingController@showcashmanual');
Route::delete('/showcreditmanual/{posid}/{stdate}/{endate}','ClosingController@showcreditmanual');
Route::delete('/showsettincdata/{posid}/{stdate}/{endate}','ClosingController@showsettincdata');
Route::post('/bankdetinfo','ClosingController@bankdetinfo');
Route::post('saveIncome','ClosingController@store');
Route::post('/ZnumVal','ClosingController@ZnumVal');
Route::post('/SlipNumVal','ClosingController@SlipNumVal');
Route::get('/showclosingdata/{id}','ClosingController@showclosingdata');
Route::get('/downloadzdoc/{id}/{file}','ClosingController@downloadzdoc');
Route::get('/downloadsldoc/{id}/{file}','ClosingController@downloadsldoc');
Route::delete('/mrcdetaildata/{id}','ClosingController@mrcdetaildata');
Route::delete('/bankdetaildata/{id}','ClosingController@bankdetaildata');
Route::post('/verfyinc','ClosingController@verfyinc');
Route::post('/pendinginc','ClosingController@pendinginc');
Route::post('/confirminc','ClosingController@confirminc');
Route::post('/voidincfollowup','ClosingController@voidincfollowup');
Route::post('/undovoidfollowup','ClosingController@undovoidfollowup');
Route::get('/incatt/{id}','ClosingController@IncomeAttachment');

Route::get('/bankrep','ClosingController@indexrep');//bank report index
Route::post('/bankreplist/{from}/{to}','ClosingController@bankreplist');//bank report data
//---------------End finance closing--------------------

//---------------Start Settlement-----------------------
Route::get('/settlement','SettlementController@index');
Route::delete('/settlementList/{fy}','SettlementController@settlementListCon');
Route::delete('/salessettlementlist/{fy}','SettlementController@salesSettlementListCon');
Route::get('/showCreditSales/{cid}/{sid}/{fiscalyr}','SettlementController@showCreditSalesCon');
Route::get('/showallcreditsl/{fy}','SettlementController@totalcreditsales');
Route::get('/showallcreditpr','SettlementController@totalcreditpurchase');
Route::delete('/showDetailCreditSales/{id}','SettlementController@showDetailCreditSalesCon');
Route::post('settleSales','SettlementController@settleSalesCon');
Route::post('settleSalesupd','SettlementController@settleSalesupdCon');
Route::post('voidSettlement','SettlementController@voidSettlementCon');
Route::delete('/showSettledList/{id}','SettlementController@showSettledListCon');
Route::get('/getSettlementEdit/{id}','SettlementController@getSettlementCon');
Route::delete('/showDetailTransaction/{id}','SettlementController@showDetailTransactionCon');
Route::get('/getSettlementSales/{id}','SettlementController@getSettlementSalesCon');
Route::post('/getcreditcustomer/{id}','SettlementController@getCreditCustomers');
Route::post('/getfsnumber/{id}/{cusid}','SettlementController@getSalesDocNumber');
Route::get('/showSettlementInfo/{id}/{sid}','SettlementController@showSettlementInfoCon');
Route::post('saveSettlement','SettlementController@store');
Route::get('/salessettedit/{id}','SettlementController@editSettlements');
Route::get('/showdocinfos/{pos}/{cus}','SettlementController@showdocinfos');
Route::delete('/showdocinfodata/{pos}/{cus}','SettlementController@showDocinformations');
Route::get('/showsettlementrec/{id}','SettlementController@showsettlementrec');
Route::delete('/showdetailtransactions/{id}','SettlementController@showdetailtransactions');
Route::post('/verifyStatus','SettlementController@updateVerified');
Route::post('/pendingsettStatus','SettlementController@updateSettPending');
Route::post('/confirmSettStatus','SettlementController@updateSettConfirmed');
Route::post('/voidSett','SettlementController@settlementVoid');
Route::post('/undovoidSett','SettlementController@undoSettlement');
Route::get('/showcrsales/{fyear}','SettlementController@showcreditsalesett');
Route::get('/showcrsalescus/{cus}/{fyear}','SettlementController@showcreditsalecussett');
Route::delete('/showcussett/{id}','SettlementController@showcustomersettlement');
Route::get('/settatt/{id}','SettlementController@Settlementattachment');
Route::get('/showsalesinfo/{vnum}/{stid}','SettlementController@showsalesinfo');
Route::delete('/showcrvdetaildata/{vnum}/{stid}','SettlementController@showcrvdetaildata');
Route::post('/slipnumVal','SettlementController@slipnumVal');
//---------------End Settlement------------------

//-----------Start Inventory Note-----------
Route::get('/salereport/{id}','ReportController@index');
Route::get('/test','ReportController@tt');

Route::get('/grv/{id}','GRVController@index');
Route::get('/grv_prd/{id}','GRVController@grvprd');
Route::get('/grvComm/{id}','GRVController@grvComm');
Route::get('/req/{id}','ReqController@index');
Route::get('/reqcomm/{id}','ReqController@reqcomm');
Route::get('/dispcomm/{id}','ReqController@dispcomm');
Route::get('/rref/{id}','ReqController@reqref');
Route::get('/tr/{id}','TrController@index');
Route::get('/tref/{id}','TrController@transferref');
Route::get('/iss/{id}','IssController@index');
Route::get('/isstr/{id}','TrIssueController@index');
Route::get('/adj/{id}','AdjController@index');
Route::get('/bg/{id}','BgController@index');
Route::get('/bgp/{id}','BgPostedController@index');

Route::get('/dsbg/{id}','BgController@indexds');
Route::get('/dsbgp/{id}','BgPostedController@indexds');

Route::get('/en/{id}','BgController@indexen');
Route::get('/enp/{id}','BgPostedController@indexen');

Route::post('balance','StoreBalanceReportController@pdfStoreBalance');
Route::post('balances/{fr}/{tr}/{storeval}/{fiscalyears}','StoreBalanceReportController@pdfStoreBalances');//-----------------1
Route::post('valuereports/{fr}/{tr}/{storeval}/{fiscalyears}','InventoryValueController@valueReport');//------------3
Route::post('/getItemsBySelectedStore/{sid}/{fy}','StoreBalanceReportController@getItemsBySelectedStore');
Route::post('/getStoreBySelectedFyear/{fy}','StoreBalanceReportController@getStoreBySelectedFyear');
//-----------End Inventory Note---------

//-----------Start Report UI------------
Route::get('/movementui','StoreMovementController@index');
Route::post('itemmovementreport','StoreMovementController@pdfFiless')->name('itemmovementreport');
Route::post('fetchMovementRep','StoreMovementController@fetchMovementRep');

Route::post('movement/{fr}/{tr}/{storeval}/{fiscalyears}/{trtype}','StoreMovementController@pdfFiless');
Route::get('/balanceui','StoreBalanceReportController@index');
Route::get('/value','InventoryValueController@index');


Route::get('/dsmovement','DsStoreMovementController@index');
Route::post('dsmovementshow/{fr}/{tr}/{storeval}/{fyear}/{trtype}','DsStoreMovementController@pdfFiless');//-------------------4
Route::post('/getDsItemsBySelectedStore/{sid}/{fyear}','DsStoreMovementController@getDsItemsBySelectedStore');
Route::post('fetchDSMovementRep','DsStoreMovementController@fetchDSMovementRep');
Route::post('/getDSStoreBySelectedFyear/{fy}','DsStoreMovementController@getDSStoreBySelectedFyear');

Route::get('/dsbalance','DsStoreBalanceReportController@index');
Route::post('fetchDSBalanceRep','DsStoreBalanceReportController@fetchDSBalanceRep');
Route::post('dsbalances/{fr}/{tr}/{storeval}','DsStoreBalanceReportController@pdfStoreBalances');//-------------5

Route::get('/dsvalue','DsInventoryValueController@index');
Route::post('dsvaluereports/{fr}/{tr}/{storeval}','DsInventoryValueController@valueReport');//---------------6
//-----------End Report UI--------------

//-------------Purchase Report-----------------
Route::get('/purchaseuitest','PurchaseController@PurchaseReportContest');
Route::get('/purchaseui','PurchaseController@purchaseReport');
Route::get('/purchasebysupplierui','PurchaseController@purchasebySuppReport');
Route::get('/purchasebyitemui','PurchaseController@purchasebyItemReport');
Route::get('/purchasedetailui','PurchaseController@detailPurchase');
Route::post('/purchasereport/{from}/{to}/{store}/{paymenttype}','PurchaseController@PurchaseReportCon');
Route::post('/purchasebysupplier/{from}/{to}/{store}/{paymenttype}','PurchaseController@PurchaseBySupplier');//------------------7
Route::post('/purchasebyitem/{from}/{to}/{store}/{paymenttype}','PurchaseController@PurchasebyItem');
Route::get('/purchasedetail/{from}/{to}/{store}/{paymenttype}/{itemgroup}','PurchaseController@PurchaseDetailCon');
//-------------End Purchase Report----------------

//-------------Reorder Report-----------------
Route::get('/reorder','ReorderReportController@index');
Route::delete('/reorderrep','ReorderReportController@reorderrep');
//-------------End Reorder Report-----------------

//-----------Start PL report----------------
Route::get('/plreport','ProfitLossController@index');
Route::get('/plreportsum','ProfitLossController@indexsum');
Route::get('/plreportitm','ProfitLossController@indexitm');
Route::get('/plreportcus','ProfitLossController@indexcus');
Route::delete('/getSalesStore/{fy}','ProfitLossController@getSalesStore');
Route::delete('/getItemsBySelectedStorePl/{sid}/{fy}','ProfitLossController@getItemsBySelectedStorePl');
Route::delete('/getCusBySelectedStorePl/{sid}/{fy}','ProfitLossController@getCusBySelectedStorePl');
Route::post('plreportbl/{fr}/{tr}/{storeval}/{fiscalyears}/{trtype}/{ptype}/{pltype}','ProfitLossController@plreportcon');
Route::post('plreporsumtbl/{fr}/{tr}/{storeval}/{fiscalyears}/{trtype}/{ptype}/{pltype}','ProfitLossController@plreportconsum');
Route::post('plreporitmtbl/{fr}/{tr}/{storeval}/{fiscalyears}/{trtype}/{ptype}/{pltype}','ProfitLossController@plreportconitm');
Route::post('plreportcustbl/{fr}/{tr}/{storeval}/{fiscalyears}/{trtype}/{ptype}/{pltype}','ProfitLossController@plreportconcus');
Route::post('plreporsumtblch/{fr}/{tr}/{storeval}/{fiscalyears}/{trtype}/{ptype}','ProfitLossController@plreportconsumch');
//-----------End PL report------------------

//----------Start Rank report----------------------
Route::get('/itemrank','RankController@index');
Route::get('/cusrank','RankController@indexrcus');
Route::post('itemranktbl/{fr}/{tr}/{storeval}/{fiscalyears}/{trtype}/{ptype}/{rval}/{sval}/{nitm}','RankController@itemrankreportcon');
Route::post('cusranktbl/{fr}/{tr}/{storeval}/{fiscalyears}/{trtype}/{ptype}/{rval}/{sval}/{nitm}','RankController@cusrankreportcon');
//----------End Rank report-----------------------

//---------Start FSN report------------------------
Route::get('/fsn','FSNController@index');
Route::post('fsnreport/{fr}/{tr}/{storeval}/{fiscalyears}','FSNController@fsnReportCon');
Route::delete('/getItemsBySelectedStoreFsn/{sid}/{fy}','FSNController@getItemsBySelectedStoreFsn');
Route::delete('/getStoreBySelectedFyearFsn/{fy}','FSNController@getStoreBySelectedFyearFsn');
//--------End FSN report--------------------------

//----------Start DS PL report---------------------
Route::get('/dsplreport','DSProfitController@index');
Route::get('/dsplreportsum','DSProfitController@indexdssum');
Route::get('/dsplreportcus','DSProfitController@indexdscus');
Route::get('/dsplreportitm','DSProfitController@indexdsitm');
Route::delete('/getdspostore/{fy}','DSProfitController@getdspostore');
Route::delete('/getDsCusBySelectedStorePl/{sid}/{fy}','DSProfitController@getDSCusBySelectedStorePl');
Route::delete('/getDSItemsBySelectedStorePl/{sid}/{fy}','DSProfitController@getDSItemsBySelectedStorePl');
Route::post('dsplreportbl/{fr}/{tr}/{storeval}/{fiscalyears}/{trtype}/{ptype}/{pltype}','DSProfitController@dsplreportcon');
Route::post('dsplreporsumtbl/{fr}/{tr}/{storeval}/{fiscalyears}/{trtype}/{ptype}/{pltype}','DSProfitController@dsplreportconsum');
Route::post('dsplreportcustbl/{fr}/{tr}/{storeval}/{fiscalyears}/{trtype}/{ptype}/{pltype}','DSProfitController@dsplreportconcus');
Route::post('dsplreporitmtbl/{fr}/{tr}/{storeval}/{fiscalyears}/{trtype}/{ptype}/{pltype}','DSProfitController@dsplreportconitm');
//----------End DS PL report-----------------------

//-----------Start DS FSN report-------------------
Route::get('/dsfsn','DSFSNController@index');
Route::post('dsfsnreport/{fr}/{tr}/{storeval}/{fiscalyears}','DSFSNController@dsfsnReportCon');
Route::delete('/dsgetItemsBySelectedStoreFsn/{sid}/{fy}','DSFSNController@dsgetItemsBySelectedStoreFsn');
Route::delete('/dsgetStoreBySelectedFyearFsn/{fy}','DSFSNController@dsgetStoreBySelectedFyearFsn');
//-----------Start DS FSN report-------------------

//-----------Start DS Rank report------------------
Route::get('/dsitemrank','DSRankController@index');
Route::get('/dscusrank','DSRankController@indexdscusrank');
Route::post('dsitemranktbl/{fr}/{tr}/{storeval}/{fiscalyears}/{trtype}/{ptype}/{rval}/{sval}/{nitm}','DSRankController@dsitemrankreportcon');
Route::post('dscusranktbl/{fr}/{tr}/{storeval}/{fiscalyears}/{trtype}/{ptype}/{rval}/{sval}/{nitm}','DSRankController@dscusrankreportcon');
//-----------End DS Rank report--------------------

//----------Start Custom report--------------------
Route::get('/custom','CustomReportController@index');
Route::post('custdata/{fr}/{tr}/{storeval}','CustomReportController@custdata');

Route::get('/prcustom','CustomReportController@prindex');
Route::post('prdata/{fr}/{tr}/{storeval}','CustomReportController@suppdata');
//----------End Custom report---------------------

//----------Start Fitness report-------------------
Route::get('/generalservice','FitnessReportController@generalServiceReport');
Route::get('/servicebyservice','FitnessReportController@serviceByServiceReport');
Route::get('/servicebyclient','FitnessReportController@serviceByClientReport');
Route::get('/invoicedetail','FitnessReportController@invoiceDetailReport');
Route::get('/servicestatus','FitnessReportController@serviceStatusReport');
//----------End Fitness report---------------------

//--------Start Fitness Data report-------------------
Route::post('/generalservicedata/{from}/{to}/{paymenttype}','FitnessReportController@generalServiceData');
Route::post('/servicebyservicedata/{from}/{to}/{paymenttype}/{invtype}','FitnessReportController@servicebyServiceData');
Route::post('/servicebyclientdata/{from}/{to}/{paymenttype}/{invtype}','FitnessReportController@servicebyClientData');
Route::post('/incomebyinvoicedata/{from}/{to}/{paymenttype}/{invtype}','FitnessReportController@incomebyInvoiceData');
Route::post('/servicestatusdata/{from}/{to}/{servstatus}/{invtype}','FitnessReportController@serviceStatusData');
//-------End Fitness Data report-------------------

//-----------Start Dashboard report----------------
Route::get('/dashboard','DashboardController@index');
Route::post('/getcustomersuppcnt','DashboardController@getSupplierCnt');
Route::post('/getitemcnt','DashboardController@getItemCnt');
Route::post('/getsalescnt','DashboardController@getSalesCnt');
Route::post('/getitemval','DashboardController@getItemval');
Route::post('/getusercnt','DashboardController@getUserval');
Route::post('/gettodaysales','DashboardController@getTodaysSales');
Route::post('/getsalestr','DashboardController@getSalesTrend');
Route::post('/getsalespt','DashboardController@getSalesPaymentType');
Route::post('/getsalesvt','DashboardController@getSalesVoucherType');
Route::post('/getprmargin','DashboardController@getprofitmargin');
//-----------End Dashboard report------------------

//-----------Start Sales report--------------------
Route::get('/salereport/{id}','ReportController@index');
Route::get('/saleReport','ReportController@saleReport');
Route::get('/salebycustomer','ReportController@salebycustomer');
Route::get('/salebyitem','ReportController@salebyitem');
Route::get('/witholdView','ReportController@witholdreportIndex');
Route::get('/salesdetailview','ReportController@salesDetailIndex');
Route::get('/salesdetailreport/{from}/{to}/{store}/{paymenttype}/{itemgroup}','ReportController@HtmlToPDF');
Route::get('/salesdetailreportbycustomer/{customer}/{from}/{to}/{store}/{paymenttype}/{itemgroup}','ReportController@salesbycustomer');
Route::get('/salesdetailreportbyitem/{item}/{from}/{to}/{store}/{paymenttype}/{itemgroup}','ReportController@salesbyitem');
Route::get('/salesdetailreportmain/{from}/{to}/{store}/{paymenttype}/{itemgroup}','ReportController@SalesDetailCon');
Route::get('/witholdandvatreport/{customer}/{from}/{to}/{store}/{paymenttype}/{status}','ReportController@witholdreport');
//-----------End Sales report---------------

//--------------Start Banks-----------------
Route::get('/bank','BankController@index');
Route::post('saveBank','BankController@store');
Route::delete('/banklist','BankController@banklistcon');
Route::post('/accNumberVal','BankController@getAccountNumber');
Route::get('/showbanks/{id}','BankController@showbankCon');
Route::delete('/banklistinfo/{id}','BankController@banklistinfoCon');
Route::post('deletebank','BankController@deleteBank');
Route::post('/conNumVal','BankController@getContactNumber');
//--------------Ends Banks-----------------

//--------------Start Service--------------
Route::get('/service','ServiceController@index');
Route::post('saveService','ServiceController@store');
Route::delete('/servicelist','ServiceController@serviceListCon');
Route::get('/showservice/{id}','ServiceController@showserviceCon');
Route::delete('/servicelistinfo/{id}','ServiceController@servicelistinfoCon');
Route::post('deleteservice','ServiceController@deleteSer');
//--------------End Service-------------

//----------Start Membership--------------
Route::get('/membership','MembershipController@index');
Route::post('savemembership','MembershipController@store');
Route::delete('/membershiplist','MembershipController@memberListCon');
Route::get('/showmember/{id}','MembershipController@showmemberCon');
Route::get('/downloadidn/{id}/{file}', 'MembershipController@download');
Route::post('deletemember','MembershipController@deleteMem');
Route::post('getFaceid','MembershipController@getFaceid');
Route::post('getFingerprint','MembershipController@getFingerprint');
//----------End Membership----------------

//---------Start Staff--------------
Route::get('/employe','EmployeController@index');
Route::post('saveemployee','EmployeController@store');
Route::delete('/employeelist','EmployeController@employeeListCon');
Route::post('deleteemp','EmployeController@deleteEmp');
Route::get('/showemp/{id}','EmployeController@showempCon');
Route::get('/downloadidnemp/{id}/{file}', 'EmployeController@downloademp');
Route::post('getEmpFaceid','EmployeController@getEmpFaceid');
Route::post('getEmpFingerprint','EmployeController@getEmpFingerprint');
//---------End Staff----------------

//---------Start Group-----------------
Route::get('/group','GroupController@index');
Route::delete('/grouplist','GroupController@groupListCon');
Route::post('savegroup','GroupController@store');
Route::get('/showgroup/{id}','GroupController@showgroup');
Route::post('deletegroup','GroupController@deletegroup');
//---------End Group----------------

//---------Start Payment Term-----------------
Route::get('/paymentterm','PaymenttermController@index');
Route::delete('/paymenttermlist','PaymenttermController@paymenttermList');
Route::post('savepayment','PaymenttermController@store');
Route::get('/showpaymentterm/{id}','PaymenttermController@showpaymentterm');
Route::post('deletepayment','PaymenttermController@deletepayment');
//---------End Payment Term-------------------

//---------Start Period-----------------
Route::get('/period','PeriodController@index');
Route::delete('/periodlist','PeriodController@periodlist');
Route::post('saveperiod','PeriodController@store');
Route::get('/showperiod/{id}','PeriodController@showperiod');
Route::post('deleteperiod','PeriodController@deleteperiod');
Route::delete('/perioddetaillist/{id}','PeriodController@perioddetaillist');
//---------End Period-------------------

//----------Start Application Form--------------
Route::get('/application','ApplicationFormController@index');
Route::post('/applicationlist','ApplicationFormController@applicationListCon');
Route::post('/memberlist','ApplicationFormController@memberListCon');
Route::post('/paymentlist','ApplicationFormController@getPaymentList');
Route::post('/paymentextendlist','ApplicationFormController@getExtendpaymentlist');
Route::post('/groupattr','ApplicationFormController@getGroupAttr');
Route::post('/ptermattr','ApplicationFormController@getPaymenntTermAttr');
Route::post('/memberListinfo','ApplicationFormController@getMemberList');
Route::post('/registrationDate','ApplicationFormController@regDateCon');
Route::post('saveApp','ApplicationFormController@store');
Route::post('/mrcList','ApplicationFormController@getMrcList');
Route::get('/showappedit/{id}','ApplicationFormController@showappeditCon');
Route::delete('/showmemservdata/{id}','ApplicationFormController@showEachMember');
Route::delete('/showmemprice/{id}','ApplicationFormController@showMemberPrice');
Route::delete('/showmempricetr/{id}','ApplicationFormController@showMemberPriceTr');
Route::get('/showvoidinfo/{id}','ApplicationFormController@showVoidInfo');
Route::post('/voidAppSett','ApplicationFormController@voidApplication');
Route::get('/showundovoidinfo/{id}','ApplicationFormController@showundoVoidInfo');
Route::post('/undoAppSett','ApplicationFormController@undoVoidAppliaction');
Route::post('/verifyAppStatus','ApplicationFormController@updateAppVerified');
Route::get('/showfreezeinfo/{id}','ApplicationFormController@showfreezeinfo');
Route::post('saveFreezeUnFreeze','ApplicationFormController@saveFreezeUnFreeze');
Route::post('/paymentlisttrn','ApplicationFormController@getPaymentListTrn');
Route::post('/getServicePeriod','ApplicationFormController@getServicePeriodTrn');
Route::post('/refundAppSett','ApplicationFormController@refundApplication');
Route::post('/undoRefundAppSett','ApplicationFormController@undoRefundAppliaction');
Route::delete('/showdetailservice/{id}','ApplicationFormController@showDetailService');
Route::post('/getPaymentTypeInfo','ApplicationFormController@getPaymentTypeInfo');
Route::get('/downloadingapp/{id}/{file}','ApplicationFormController@downloadapp');
Route::post('/getlatestapp','ApplicationFormController@getlatestapp');
Route::post('/sendToDevice','ApplicationFormController@sendToDevice');
Route::post('/syncClients','ApplicationFormController@syncClients');
Route::post('/syncToDevice','ApplicationFormController@syncToDevice');
//----------End Application Form----------------

//----------Start Setting ----------------
Route::get('/setting','SettingController@index');
Route::delete('/showsettingmrc','SettingController@showCompMrcData');
Route::post('/savecompanymrc','SettingController@storeCompanyMRC');
Route::get('/mrcupdatecompany/{id}','SettingController@updateCustomerMRC');
Route::delete('/mrccompanydelete/{id}', 'SettingController@deleteCompanyMRC');
Route::post('savesetting','SettingController@store');
Route::get('getCompLogo','SettingController@getlogo');
Route::delete('/showfiscalperiods','SettingController@showFiscalYearPeriods');
Route::post('changeFiscalYear','SettingController@changeFiscalYear');
Route::get('storewithmrcset','SettingController@storewithmrcset');
Route::get('manualstore','SettingController@manualstore');
Route::post('savepos','SettingController@savepos');
Route::post('savemanualpos','SettingController@savemanualpos');
Route::get('/getmrcwithstore/{id}','SettingController@getmrcwithstore');
Route::get('/updatefsnumber/{id}','SettingController@updatefsnumber');
Route::get('/deletefsnumber/{id}','SettingController@deletefsnumber');
Route::get('/editmanualnumber/{id}','SettingController@editmanualnumber');
Route::get('/deletemanulnumber/{id}','SettingController@deletemanulnumber');

Route::post('saveOtSetting','SettingController@saveOtSetting');
Route::get('/otSettingData','SettingController@overtimeSettingData');
Route::get('/payrollSettingData','SettingController@payrollSettingData');
Route::post('deleteOtSetting','SettingController@deleteOtSetting');
//----------End Setting--------------------

//----------Start Import Data--------------
Route::get('/import','ImportDataController@index');
Route::post('/importdata','ImportDataController@import');
//----------End Import Data----------------

//----------Start Booking------------------
Route::get('/booking','BookingController@index');
//----------End Booking--------------------
/** BEGIN: region controller route */
Route::get('/region', [RegionController::class, 'index'])->name('region.index');
Route::delete('/get-region', [RegionController::class, 'getregions'])->name('get.regions');
Route::post('regions.store/{id?}', [RegionController::class, 'store'])->name('region.store');
Route::get('/region_edit/{id}', [RegionController::class, 'edit'])->name('region.edit');
Route::get('/region_show/{id}', [RegionController::class, 'show'])->name('region.show');
Route::delete('delete-region/{id}', [RegionController::class, 'destroy'])->name('region.destroy');
/** END: region controller route */
/** BEGIN: zone controller route */
Route::get('/zone', [ZoneController::class, 'index'])->name('zone.index');
Route::delete('/get-zone', [ZoneController::class, 'getzones'])->name('get.zones');
Route::delete('/zoneinfo/{id}', [ZoneController::class, 'getzoneinfo'])->name('get.zoneinfo');
Route::post('/saveZone/{id?}', [ZoneController::class, 'store'])->name('zone.store');
Route::get('/showzones/{id}', [ZoneController::class, 'edit'])->name('zone.edit');
Route::get('/show_zone/{id}', [ZoneController::class, 'show'])->name('zone.show');
Route::get('/del_zone/{id}', [ZoneController::class, 'trytodeletezone'])->name('zone.trydestroy');
Route::get('/deletezone/{id}', [ZoneController::class, 'deletezone'])->name('zone.deletezone');
Route::get('/Woredaval', [ZoneController::class, 'woredacheck']);
/** END: zone controller route */

//----------Start Woreda--------------
Route::get('/woreda','WoredaController@index');
Route::delete('/woredalist','WoredaController@woredalist');
Route::post('saveWoreda','WoredaController@store');
Route::get('/showWoreda/{id}','WoredaController@showWoreda');
Route::post('deleteWoreda','WoredaController@deleteWoreda');
//----------End Woreda----------------

// start of pr route
    Route::get('pr','PurchaseRequestController@index');
    Route::get('ajj','AfmembersController@index');
    Route::get('memberlist','AfmembersController@memberlist');
    Route::get('showqrcode','AfmembersController@showqrcode');
    Route::get('showid','AfmembersController@showid');
    Route::get('purchaslist/{fy}','PurchaseRequestController@purchaslist');
    Route::get('checkreview/{fy}','PurchaseRequestController@checkreview');
    Route::get('reviewlist/{fy}','PurchaseRequestController@reviewlist');
    Route::get('prinfo/{id}','PurchaseRequestController@prinfo');
    Route::post('prsave','PurchaseRequestController@store');
    Route::get('purchaseinfoitemlist/{id}','PurchaseRequestController@purchaseinfoitemlist');
    Route::get('purchaseinfocomoditylist/{id}','PurchaseRequestController@purchaseinfocomoditylist');
    Route::get('predit/{id}','PurchaseRequestController@predit');
    Route::post('purchasevoid','PurchaseRequestController@purchasevoid');
    Route::get('purchaseaction/{id}/{status}','PurchaseRequestController@purchaseaction');
    Route::get('prpermit/{checkid}','PurchaseRequestController@prpermit');
    Route::get('undoprpermit/{checkid}','PurchaseRequestController@undoprpermit');
    Route::get('/prattachemnt/{id}','PurchaseRequestController@prattachemnt');
//end of pr route
// start of rfq route
    Route::get('rfq','RfqController@index');
    Route::get('rfqslist/{fyear}','RfqController@rfqslist');
    Route::post('rfqsave','RfqController@store');
    Route::get('rfqinfo/{id}','RfqController@rfqinfo');
    Route::get('showsupplier/{id}','RfqController@showsupplier');
    Route::post('rfqvoid','RfqController@rfqvoid');
    Route::get('rfqaction/{id}/{status}','RfqController@rfqaction');
    Route::get('rfqedit/{id}','RfqController@rfqedit');
    Route::get('/rfqattachemnt/{id}/{customercode}','RfqController@rfqattachemnt');
    Route::get('getstores/{id}','RfqController@getstores');
    Route::post('savesubmissionsupplier','RfqController@savesubmissionsupplier');
    Route::get('editcustomerfq/{id}','RfqController@editcustomerfq');
    Route::get('removesupplier/{id}','RfqController@removesupplier');
    Route::get('checkevalationisrtart/{id}/{supplierid}','RfqController@checkevalationisrtart');
    Route::get('checksubmissionstartornot/{id}','RfqController@checksubmissionstartornot');
//end of rfq route
// start of purchase evualation route
    Route::get('pe','PurchasevaulationController@index');
    Route::get('pevualationlist/{type}/{fy}','PurchasevaulationController@pevualationlist');
    Route::post('pesave','PurchasevaulationController@store');
    Route::post('peupdate','PurchasevaulationController@update');
    Route::get('getrfq/{type}','PurchasevaulationController@getrfq');
    Route::get('getprequestdata/{id}','PurchasevaulationController@getprequestdata');
    Route::get('peinfo/{id}','PurchasevaulationController@peinfo');
    Route::get('showsupplierforpe/{id}','PurchasevaulationController@showsupplierforpe');
    Route::get('peinfocomoditylist/{id}','PurchasevaulationController@peinfocomoditylist');
    Route::get('peinfoitemlist/{id}','PurchasevaulationController@peinfoitemlist');
    Route::get('pedit/{id}','PurchasevaulationController@edit');
    Route::get('specificsupplieredit/{id}/{supplierid}','PurchasevaulationController@specificsupplieredit');
    Route::post('supliersave','PurchasevaulationController@supliersave');
    Route::get('pevualationseaction/{id}/{status}','PurchasevaulationController@pevualationseaction');
    Route::post('purchasevaliotionvoid','PurchasevaulationController@purchasevaliotionvoid');
    Route::get('requesteditems/{id}/{reference}/{type}','PurchasevaulationController@requesteditems');
    Route::get('getallsuppliers','PurchasevaulationController@getallsuppliers');
    Route::get('getallproducts/{type}','PurchasevaulationController@getallproducts');
    Route::get('peinitationedit/{id}','PurchasevaulationController@peinitationedit');
    Route::get('getinitiationdata/{id}/{type}','PurchasevaulationController@getinitiationdata');
    Route::get('evualatedit/{id}','PurchasevaulationController@evualatedit');
    Route::post('technicalevsave','PurchasevaulationController@technicalevsave');
    Route::get('addrequesteditems/{rfq}/{reference}/{type}','PurchasevaulationController@addrequesteditems');
    Route::get('tecevualatedit/{id}','PurchasevaulationController@tecevualatedit');
    Route::post('financialsave','PurchasevaulationController@financialsave');
    Route::get('getpebysupplier/{headerid}/{id}','PurchasevaulationController@getpebysupplier');
    Route::get('peattachemnt/{headerid}/{id}','PurchasevaulationController@peattachemnt');
    Route::get('getinitationcommodity/{headerid}','PurchasevaulationController@getinitationcommodity');
//end of purchase evualation route
//srart porder route
    Route::get('purchaseorder','PurchaseOrderController@index');
    Route::get('purchaseordelist','PurchaseOrderController@purchaseordelist');
    Route::get('getpassedpev/{pe}','PurchaseOrderController@getpassedpev');
    Route::get('getpordersupplier/{pe}/{supplierid}','PurchaseOrderController@getpordersupplier');
    Route::get('getpordersupplierdatas/{pe}','PurchaseOrderController@getpordersupplierdatas');
    Route::get('poinfo/{pe}','PurchaseOrderController@poinfo');
    Route::get('showsupplierpo/{id}','PurchaseOrderController@showsupplierpo');
    Route::get('getwineditems/{header}/{id}','PurchaseOrderController@getwineditems');
    Route::get('infogetwineditems/{headerid}/{id}','PurchaseOrderController@infogetwineditems');
    Route::post('posuppliersave','PurchaseOrderController@posuppliersave');
    Route::post('posavedraftdata','PurchaseOrderController@posavedraftdata');
    Route::get('poedit/{id}','PurchaseOrderController@poedit');
    Route::get('suppliercommodity/{headerid}/{id}','PurchaseOrderController@suppliercommodity');
    Route::get('supplieraction/{headerid}/{id}/{status}','PurchaseOrderController@supplieraction');
    Route::get('podirectaction/{id}/{status}','PurchaseOrderController@podirectaction');
    Route::get('listallpologs/{id}','PurchaseOrderController@listallpologs');
    Route::get('addorderdata/{headerid}/{supplierid}','PurchaseOrderController@addorderdata');
    Route::get('directcommoditylist/{id}','PurchaseOrderController@directcommoditylist');
    Route::get('directgoodlist/{id}','PurchaseOrderController@directgoodlist');
    Route::get('directpoattachemnt/{id}','PurchaseOrderController@directpoattachemnt');
    Route::post('povoid','PurchaseOrderController@povoid');
    Route::get('checkfordupplication/{headerid}/{itemid}/{supplierid}','PurchaseOrderController@checkfordupplication');
    Route::post('supplierpovoid','PurchaseOrderController@supplierpovoid');
    Route::get('suppliierdirectpoattachemnt/{headerid}/{supplierid}','PurchaseOrderController@suppliierdirectpoattachemnt');
    Route::get('pocheckreview','PurchaseOrderController@pocheckreview');
    Route::get('poreviewlist','PurchaseOrderController@poreviewlist');
    Route::get('poreviewlisting','PurchaseOrderController@poreviewlisting');
    Route::get('poundoprpermit/{checkid}','PurchaseOrderController@poundoprpermit');
    Route::get('poprpermit/{checkid}','PurchaseOrderController@poprpermit');
    Route::get('purchaseordereport','PurchaseOrderController@purchaseordereport');
    Route::get('purchaseorderfiltersupplier/{from}/{to}','PurchaseOrderController@purchaseorderfiltersupplier');
    Route::post('purchaseordergetporeference','PurchaseOrderController@purchaseordergetporeference');
    Route::post('purchaseordergetcommodtyperpo','PurchaseOrderController@purchaseordergetcommodtyperpo');
    Route::post('purchaseordereportdispaly','PurchaseOrderController@purchaseordereportdispaly');
    Route::get('goodsuom/{item}','PurchaseOrderController@goodsuom');
    Route::get('getgoodstorebalance/{item}/{store}','PurchaseOrderController@getgoodstorebalance');
// end porder route

//srart porder route
    Route::get('pc','PurchaseContractController@index');
    Route::get('contractlist','PurchaseContractController@contractlist');
    Route::post('pcsave','PurchaseContractController@store');
    Route::get('pcinfo/{id}','PurchaseContractController@pcinfo');
    Route::post('pcsavesupplier','PurchaseContractController@pcsavesupplier');
    Route::get('infogetsupllers/{headerid}/{id}','PurchaseContractController@infogetsupllers');
    Route::get('suppliercontractcommodity/{headerid}','PurchaseContractController@suppliercontractcommodity');
    Route::get('getsuplleritems/{headerid}','PurchaseContractController@getsuplleritems');
    Route::get('pcsupplieraction/{headerid}/{status}','PurchaseContractController@pcsupplieraction');
    Route::post('pcvoid','PurchaseContractController@pcvoid');
    Route::post('ajax-upload', [PurchaseContractController::class, 'uploadPDFViaAjax'])->name('ajax.upload.pdf');
    Route::get('downloadcontract/{headerid}','PurchaseContractController@downloadcontract');
// end porder route
//start payment request 
    Route::get('paymentrequest','PaymentrequestController@index');
    Route::get('paymentrequestlist','PaymentrequestController@paymentrequestlist');
    Route::get('papoinfo/{id}/{suplier}','PaymentrequestController@papoinfo');
    Route::post('paymentrequestsavedata','PaymentrequestController@store');
    Route::get('payrinfo/{id}','PaymentrequestController@payrinfo');
    Route::get('payrequestcommoditylist/{id}','PaymentrequestController@payrequestcommoditylist');
    Route::get('payrequestpocommoditylist/{id}','PaymentrequestController@payrequestpocommoditylist');
    Route::get('payrdirectcommoditylist/{id}/{stat}','PaymentrequestController@payrdirectcommoditylist');
    Route::get('paymentrequestaction/{id}/{stat}','PaymentrequestController@paymentrequestaction');
    Route::get('getreference/{id}/{productype}','PaymentrequestController@getreference');
    Route::get('downloadpaymentrequest/{headerid}','PaymentrequestController@downloadpaymentrequest');
    Route::post('payrvoid','PaymentrequestController@payrvoid');
    Route::get('editepaymentrequest/{headerid}','PaymentrequestController@editepaymentrequest');
    Route::get('checkdirectexist/{suplier}','PaymentrequestController@checkdirectexist');
    Route::get('historypaymentrequestlist/{po}/{suplier}','PaymentrequestController@historypaymentrequestlist');
    Route::get('paymentrequestattachemnt/{id}','PaymentrequestController@paymentrequestattachemnt');
    Route::get('getotalpodetiails/{id}','PaymentrequestController@getotalpodetiails');
    Route::get('getpaymentreference/{id}/{reference}/{paymentreference}','PaymentrequestController@getpaymentreference');
    Route::post('/calcRemAmount','PaymentrequestController@calcRemAmount');
    Route::get('paymentrequestreport','PaymentrequestController@paymentrequestreport');
    Route::post('pofilter','PaymentrequestController@pofilter');
    Route::post('paymentrequestreportdispaly','PaymentrequestController@paymentrequestreportdispaly');
    Route::post('pofilteringstatus','PaymentrequestController@pofilteringstatus');
    Route::get('filtersupplier/{from}/{to}','PaymentrequestController@filtersupplier');
    Route::post('getcommodtyperpo','PaymentrequestController@getcommodtyperpo');
    Route::post('getporeference','PaymentrequestController@getporeference');
    Route::get('getgoodpurchaseorder/{poid}','PaymentrequestController@getgoodpurchaseorder');
    Route::get('getpaymentrequestgoods/{poid}','PaymentrequestController@getpaymentrequestgoods');
    Route::get('directwithitemsgood/{id}','PaymentrequestController@directwithitemsgood');
// end of payment request 

//srart payment invoice 
    Route::get('purchaseinvoice','PaymentInvoiceController@index');
    Route::get('pipoinfo/{id}/{type}','PaymentInvoiceController@pipoinfo');
    Route::get('getcustomermrc/{id}','PaymentInvoiceController@getcustomermrc');
    Route::post('purchaseinvoicesavedata','PaymentInvoiceController@store');
    Route::get('paymentinvloicelist/{fy}','PaymentInvoiceController@paymentinvloicelist');
    Route::get('purinvoinfo/{id}','PaymentInvoiceController@purinvoinfo');
    Route::get('purcachaseinvloicecommoditylist/{id}','PaymentInvoiceController@purcachaseinvloicecommoditylist');
    Route::get('editepurchaseeinvloice/{headerid}','PaymentInvoiceController@editepurchaseeinvloice');
    Route::get('pigetotalpodetiails/{id}','PaymentInvoiceController@pigetotalpodetiails');
    Route::get('pihistorypaymentrequestlist/{po}','PaymentInvoiceController@pihistorypaymentrequestlist');
    Route::get('pipaymentrequestaction/{id}/{stat}','PaymentInvoiceController@pipaymentrequestaction');
    Route::post('pipayrvoid','PaymentInvoiceController@pipayrvoid');
    Route::get('getrecivaledata/{headerid}','PaymentInvoiceController@getrecivaledata');
    Route::get('downloadpaymentinvoice/{headerid}','PaymentInvoiceController@downloadpaymentinvoice');
    Route::get('paymentinvoiceprint/{headerid}','PaymentInvoiceController@paymentinvoiceprint');
    Route::get('purchaseinvoicereport','PaymentInvoiceController@purchaseinvoicereport');
    Route::get('invoicefiltersupplier/{from}/{to}','PaymentInvoiceController@invoicefiltersupplier');
    Route::post('invloicepofilteringstatus','PaymentInvoiceController@invloicepofilteringstatus');
    Route::post('invoicegetcommodtyperpo','PaymentInvoiceController@invoicegetcommodtyperpo');
    Route::post('invoicereportdispaly','PaymentInvoiceController@invoicereportdispaly');
    Route::post('getinvoicereference','PaymentInvoiceController@getinvoicereference');
//end of payment invoice 
//----------Start User---------------------
Route::get('/user','UserController@index');
Route::get('/getUserNumber','UserController@getUserNumbers');
Route::post('/saveUsers','UserController@store');
Route::delete('/userdata','UserController@showUserData');
Route::delete('/getRec/{id}','UserController@getReceivingStore');
Route::delete('/getIssue/{id}','UserController@getIssueStore');
Route::delete('/getApprover/{id}','UserController@getApproverStore');
Route::delete('/getTransferRec/{id}','UserController@getTransferReceiveStore');
Route::delete('/getSales/{id}','UserController@getSalesStore');
Route::delete('/getStoreB/{id}','UserController@getStoreBalance');
Route::delete('/getStoreR/{id}','UserController@getReqStore');
Route::delete('/getStoreTrS/{id}','UserController@getTrSrcStore');
Route::delete('/getStoreTrD/{id}','UserController@getTrDesStore');
Route::delete('/getStoreAd/{id}','UserController@getAdjustmentStore');
Route::delete('/getStoreBeg/{id}','UserController@getBeginningStore');
Route::delete('/getSalesRep/{id}','UserController@getSalesRepStore');
Route::delete('/getPurRep/{id}','UserController@getPurRepStore');
Route::delete('/getInvRep/{id}','UserController@getInvRepStore');
Route::delete('/getFinRep/{id}','UserController@getFinRepStore');
Route::delete('/getMrcs/{id}','UserController@getMrcNumber');
Route::delete('/getProforma/{id}','UserController@getProformaNumber');
Route::get('/useredit/{id}','UserController@editUserData');
Route::delete('/showSalesStores/{id}','UserController@showSalesStoreData');
Route::delete('/showProformaStores/{id}','UserController@showProformaStores');
Route::delete('/showMrcdata/{id}','UserController@showUserMrcData');
Route::delete('/showRecData/{id}','UserController@showReceivingStoreData');
Route::delete('/showIssueStore/{id}','UserController@showIssueStoreData');
Route::delete('/showApproverData/{id}','UserController@showApproverStoreData');
Route::post('/resetPassW','UserController@ResetUserPassword');
// added route
Route::get('/getmrcstores','UserController@getmrcstores');
Route::get('/getmrcassignedtousers/{id}','UserController@getmrcassignedtousers');
Route::get('/getstoresmrc/{id}','UserController@getstoresmrc');
Route::get('/getstoresmrcft/{id}','UserController@getstoresmrcft');
Route::get('/getAssignedMrc/{storeid}/{userid}','UserController@getAssignedMrc');
Route::get('/getAssignedMrcFt/{storeid}/{userid}','UserController@getAssignedMrcFt');

Route::delete('/getFitness/{id}','UserController@getFitnessPos');

// roles and permission route
Route::get('/role','RoleController@index');
Route::delete('/rolelist','RoleController@getRoleList');
Route::put('/updaterole/{id}','RoleController@update');
Route::get('/editrole/{id}','RoleController@edit');
Route::delete('/getPermission','RoleController@getPermission');
Route::delete('/deleterole/{id}','RoleController@deleterole');
// end of role and permission

//start profile route
Route::get('/profile','ProfileController@index');
Route::post('/changepassword','ProfileController@store');
Route::post('/changepasswordefault','ProfileController@changepasswordefault');
Route::post('/userinfoupdate','ProfileController@userinfoupdate');
//end profile route

// notification route
Route::get('/not','NotificationController@notificationuser');
Route::get('markasread',function(){
    auth()->user()->unreadNotifications->markAsRead();
    return redirect()->back();
});
//end of notificationroute
});

















//end sale route









//Route::get('/showholdcustomer/{id}','salesController@index');



//sales Route end



//end of item route end




