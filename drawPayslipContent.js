
function drawPayslipContent(docInstance, currentYOffset) {
    let y = currentYOffset;
    const centerX = pageWidth / 2;

    // Header - Company Name
    docInstance.setFontSize(18);
    docInstance.setFont('helvetica', 'bold');
    docInstance.text(nomEntreprise, centerX, y, { align: 'center' });
    y += 8;

    // Company Details
    docInstance.setFontSize(10);
    docInstance.setFont('helvetica', 'normal');
    docInstance.text(`Adresse : ${adresseEntreprise}`, centerX, y, { align: 'center' });
    y += 5;
    docInstance.text(`N° IFU : ${numIfu} | CNSS Employeur : ${numCnssEmployeur}`, centerX, y, { align: 'center' });
    y += 10;

    // Title
    docInstance.setFontSize(14);
    docInstance.setFont('helvetica', 'bold');
    docInstance.text(`FICHE DE PAIE - ${periodePaie.toUpperCase()}`, centerX, y, { align: 'center' });
    y += 10;

    // Employee Info
    docInstance.setFontSize(11);
    docInstance.setFont('helvetica', 'bold');
    docInstance.text("Informations de l'employé", margin, y);
    y += 6;

    docInstance.setFont('helvetica', 'normal');
    const infoPairs = [
        [`Nom`, nomEmploye],
        [`Poste`, posteEmploye],
        [`Date d'embauche`, dateEmbauche],
        [`Type de contrat`, typeContrat],
        [`N° CNSS Employé`, numCnssEmploye],
        ...(dateFinContrat !== 'N/A' ? [[`Date fin contrat`, dateFinContrat]] : [])
    ];
    infoPairs.forEach(([label, value]) => {
        docInstance.text(`${label} :`, margin, y);
        docInstance.text(value, margin + 50, y);
        y += 6;
    });

    y += 8;
    docInstance.setFont('helvetica', 'bold');
    docInstance.text("Détails de la paie", margin, y);
    y += 6;
    docInstance.setFont('helvetica', 'normal');

    const brut = currentCalculationResults.find(item => item.label.includes('brut'))?.raw || 0;
    const net = currentCalculationResults.find(item => item.label.includes('net'))?.raw || 0;

    const tableLines = [
        ["Salaire brut", formatFcfa(brut)],
        ...currentCalculationResults
            .filter(item => !item.label.includes('brut') && !item.label.includes('net à payer') && !item.label.includes('Salaire net') && !item.label.includes('CNSS Patronale') && !item.label.includes('VPS'))
            .map(item => [item.label, formatFcfa(item.raw)]),
        ["Salaire net à payer", formatFcfa(net)],
        ["--- Charges patronales ---", ""],
        ...currentCalculationResults
            .filter(item => item.label.includes('CNSS Patronale') || item.label.includes('VPS'))
            .map(item => [item.label, formatFcfa(item.raw)]),
    ];

    tableLines.forEach(([label, value]) => {
        docInstance.text(`${label} :`, margin, y);
        docInstance.text(value, pageWidth - margin, y, { align: 'right' });
        y += 6;
    });

    y += 10;
    docInstance.setFont('helvetica', 'bold');
    docInstance.text(`Date de paiement : ${datePaiement}`, margin, y);
    y += 20;

    // Footer Signature
    docInstance.setFont('helvetica', 'normal');
    docInstance.text("Signature de l'employeur", pageWidth - margin, y, { align: 'right' });

    docInstance.save(`Fiche_de_Paie_${nomEmploye.replace(/\s/g, '_')}_${periodePaie.replace(/\s/g, '_')}.pdf`);
    closeModal();
}