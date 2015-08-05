// JavaScript source code


//"!!ERR!!"定义为关键字！！！！excel中不允许出现该字符



function excel_excute(url, t) {
    var tem = new Array();
    var excel_avtive = new ActiveXObject("Excel.Application");
    try {
        var sheet = excel_avtive.Workbooks.open(url);
        var otable = sheet.ActiveSheet;
        tem.push(sheet);
        tem.push(otable);
        return tem;
    } catch (e) {
        if (t) {
            var sheet = excel_avtive.Workbooks.Add;
            var ntable = sheet.WorkSheets(1);
            ntable.saveAs(url);
            tem.push(sheet);
            tem.push(ntable);
            return tem;

        } else {
            alert(e);
            return 0;
        }
    }
}

function excel_update(url, row, col, newvalue, error) {
    var t = excel_excute(url, false);
    if (t) {
        t[1].Cells(row, col).value = newvalue;
        t[0].Close(savechanges = true);
        return true;
    } else {
        alert(error);
        return false;
    }
}

function excel_query(url, row, col) {
    var t = excel_excute(url, false);
    if (t) {
        var s = t[1].Cells(row, col).value;
        t[0].Close(savechanges = false);
        return s;
    } else {
        return "!!ERR!!";
    }
}

function excel_rowcount(url, error) {
    var t = excel_excute(url, false);
    if (t) {
        var s = t[0].WorkSheets(1).UsedRange.Cells.Rows.Count;
        t[0].Close(savechanges = false);
        return s;
    } else {
        alert(error);
        return "!!ERR!!";
    }
}


//下面是具体对股票的操作

function AddStock(url, stockid, hands, price) {

    var tem = excel_excute(url, true);
    var count = tem[0].WorkSheets(1).UsedRange.Cells.Rows.Count;
    var row = 0;
    for (var i = 0; i < count - 1; i++) {
        if (tem[1].Cells(i + 1, 1).value == stockid) {
            row = i + 1;
        }
    }
    var price = parseFloat(price) * parseInt(hands)*100;
    
        if (parseFloat(tem[1].Cells(count, 1).value) < price) {
            alert("You don't have enough money\n您的账户余额不足!!");
       
        }else{
            if(row==0){
                tem[1].Cells(count + 1, 2).value = parseFloat(tem[1].Cells(count, 2).value)-price;
                tem[1].Cells(count + 1, 1).value = tem[1].Cells(count, 1).value;
                tem[1].Cells(count, 1).value = stockid;
                tem[1].Cells(count, 2).value = hands;
                tem[1].Cells(count, 3).value = price;
            } else {
                tem[1].Cells(row, 2).value = parseInt(tem[1].Cells(row, 2).value) + parseInt(hands);
                tem[1].Cells(row, 3).value = parseFloat(tem[1].Cells(row, 3).value) + price;
                tem[1].Cells(count, 2).value = parseFloat(tem[1].Cells(count, 2).value) - price;
         }
    } 
    tem[0].Close(savechanges = true);
}

function DelStock(url, stockid,price){
    var tem = excel_excute(url, false);
    var count = tem[0].WorkSheets(1).UsedRange.Cells.Rows.Count;

    var row = 0;

    for (var i = 0; i < count - 1; i++) {
        if (tem[1].Cells(i + 1, 1).value == stockid) {
            row = i + 1;
            break;
        }
    }
    
    if (row > count||row==0) {
        alert("不存在这条记录");
    } else {
        tem[1].Cells(count, 2).value = parseFloat(tem[1].Cells(count, 2).value) + parseFloat(price) ;
        tem[1].Rows(row).Delete();
    }
    tem[0].Close(savechanges = true);
}

