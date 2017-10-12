%App = ( 
	'A'		=> 'AIA v3.1',
	'ADM'	=> 'Administration',
	'B'		=> 'BI',
	'BI_'	=> 'BI',
	'CNT'	=> 'Connectique',
	'DCT'	=> 'Documentum',
	'E'		=> 'Eire',
	'EXP'	=> 'Exploitation',
	'G'		=> 'AIA v2',
	'H'		=> 'Editique',
	'HA_'	=> 'Haute dispo.',
	'I'		=> 'Infocentre',
	'L'		=> 'Logic',	
	'MFT'	=> 'Transferts',
	'ORA'	=> 'Oracle',
	'PDT'	=> 'Poste de travail',
	'SUN'	=> 'Sunnet',
	'SHR'	=> 'SharePoint',
	'TST'	=> 'Tests divers',
	'WCR'	=> 'WIncredit',
	'V'		=> 'Valorlife',
	'Z'		=> 'HR Access',
	);
	
@Cols = ('start','end','status','exit','machine','joid','run','try','application','env');
print "name	spooler	".join("\t",@Cols)."\n";
while (<STDIN>) {
	chomp;
	if (/\[(.*?)\]      CAUAJM_I_40245 EVENT: CHANGE_STATUS    STATUS: STARTING        JOB: (.*?) *MACHINE: (\w*)/) {
		$job = $2; 
		$Job{$job}->{'name'} = $job;
		$Job{$job}->{'start'} = $1;
		$Job{$job}->{'machine'} = $3;
		$Job{$job}->{'status'} = 'STARTING';
	}
	if (/\[(.*?)\]      CAUAJM_I_40245 EVENT: CHANGE_STATUS    STATUS: RUNNING         JOB: (.*?) *MACHINE: (\w*)/) {
		$job = $2; 
		$Job{$job}->{'name'} = $job;
		$Job{$job}->{'status'} = 'RUNNING';
	}
	elsif (/\[(.*?)\]      CAUAJM_I_10082 \[(.*?) connected for KILLJOB (.*?) (\d*)\.(\d*)\.(\d*)\]/) {
	}
	elsif (/\[(.*?)\]      CAUAJM_I_10082 \[(.*?) connected for (.*?) (\d*)\.(\d*)\.(\d*)\]/) {
		$job = $3; 
		$Job{$job}->{'name'} = $job;
		$Job{$job}->{'machine'} = $2;
		$Job{$job}->{'joid'} = $4;
		$Job{$job}->{'run'} = $5;
		$Job{$job}->{'try'} = $6;
		$Job{$job}->{'status'} = 'CONNECT';
	}
	#                      CAUAJM_I_40245 EVENT: CHANGE_STATUS    STATUS: SUCCESS         JOB: ORAT.RMAND.JOB.BackupInc1AgentPrimaryCheck MACHINE: xxmars          EXITCODE:  0
	elsif (/\[(.*?)\]      CAUAJM_I_40245 EVENT: CHANGE_STATUS    STATUS: (FAILURE|SUCCESS|TERMINATED) *JOB: (.*?) *MACHINE: (.*?) *EXITCODE:  (\d*)/) {
		$job = $3; 		
		$Job{$job}->{'name'} = $job;
		$Job{$job}->{'end'} = $1;
		$Job{$job}->{'status'} = $2;
		$Job{$job}->{'exit'} = $5;
		DisplayJob($job);
	}
}

# Job en running dans le log courant
foreach $j (keys %Job) {
	DisplayJob($j);
}

sub DisplayJob {
my($job) = @_;
	return unless $Job{$job}->{'name'};
	
	# Extraction de l'application et de l'environnement
	$info = $job;
	$info =~ s/^SE\./ADMP./;
	if ($info =~ /(\w*)(P|T)\./) {
		$app = $1;
		$Job{$job}->{'env'} = $2;
	}
	if ($App{$app}) {
		$Job{$job}->{'application'} = $App{$app};
	}
	else {
		$Job{$job}->{'application'} = $app;
	}
	
	print "$job\tATS";
	foreach $k (@Cols) {
		print "\t".$Job{$job}->{$k};	
	}
	print "\n";
	$Job{$job} = (); # RAZ
}