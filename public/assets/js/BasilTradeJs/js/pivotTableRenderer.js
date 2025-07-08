function renderPivotMatrixTable(pivotLevels) {
    const rows = [
      "Resistance 4",
      "Resistance 3",
      "Resistance 2",
      "Resistance 1",
      "Pivot Point",
      "Support 1",
      "Support 2",
      "Support 3",
      "Support 4",
    ];
  
    const methods = ["classic", "fibonacci", "camarilla", "woodie", "demark"];
  
    const pivotMap = {
      "Resistance 4": { classic: null, fibonacci: null, camarilla: pivotLevels.camarilla.R4, woodie: null, demark: null },
      "Resistance 3": {
        classic: pivotLevels.classic.R3,
        fibonacci: pivotLevels.fibonacci.R3,
        camarilla: pivotLevels.camarilla.R3,
        woodie: null,
        demark: null,
      },
      "Resistance 2": {
        classic: pivotLevels.classic.R2,
        fibonacci: pivotLevels.fibonacci.R2,
        camarilla: pivotLevels.camarilla.R2,
        woodie: pivotLevels.woodie.R2,
        demark: null,
      },
      "Resistance 1": {
        classic: pivotLevels.classic.R1,
        fibonacci: pivotLevels.fibonacci.R1,
        camarilla: pivotLevels.camarilla.R1,
        woodie: pivotLevels.woodie.R1,
        demark: pivotLevels.demark.R1,
      },
      "Pivot Point": {
        classic: pivotLevels.classic.P,
        fibonacci: pivotLevels.fibonacci.P,
        camarilla: pivotLevels.camarilla.P,
        woodie: pivotLevels.woodie.P,
        demark: pivotLevels.demark.P,
      },
      "Support 1": {
        classic: pivotLevels.classic.S1,
        fibonacci: pivotLevels.fibonacci.S1,
        camarilla: pivotLevels.camarilla.S1,
        woodie: pivotLevels.woodie.S1,
        demark: pivotLevels.demark.S1,
      },
      "Support 2": {
        classic: pivotLevels.classic.S2,
        fibonacci: pivotLevels.fibonacci.S2,
        camarilla: pivotLevels.camarilla.S2,
        woodie: pivotLevels.woodie.S2,
        demark: null,
      },
      "Support 3": {
        classic: pivotLevels.classic.S3,
        fibonacci: pivotLevels.fibonacci.S3,
        camarilla: pivotLevels.camarilla.S3,
        woodie: null,
        demark: null,
      },
      "Support 4": {
        classic: null,
        fibonacci: null,
        camarilla: pivotLevels.camarilla.S4,
        woodie: null,
        demark: null,
      },
    };
  
    let tableHTML = `
      <table>
        <thead>
          <tr style="background:#f2f2f2">
            <th>Result</th>
            <th>Classic</th>
            <th>Fibonacci</th>
            <th>Camarilla</th>
            <th>Woodie's</th>
            <th>Demark's</th>
          </tr>
        </thead>
        <tbody>
    `;
  
    rows.forEach(row => {
      tableHTML += `<tr><td><b>${row}</b></td>`;
      methods.forEach(method => {
        const value = pivotMap[row][method];
        tableHTML += `<td>${value !== null && value !== undefined ? value.toFixed(2) : '-'}</td>`;
      });
      tableHTML += `</tr>`;
    });
  
    tableHTML += `</tbody></table>`;
  
    $('#pivotTableContainer').html(tableHTML);
  }
  