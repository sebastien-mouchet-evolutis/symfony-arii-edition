#!/usr/bin/perl
# Transformation de l'event demon
#
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
	'OC'	=> 'Context',
	'ORA'	=> 'Oracle',
	'PDT'	=> 'Poste de travail',
	'PT'	=> 'Poste de travail',
	'SUN'	=> 'Sunnet',
	'SHR'	=> 'SharePoint',
	'TST'	=> 'Tests divers',
	'WCR'	=> 'WIncredit',
	'V'		=> 'Valorlife',
	'VM'	=> 'Véhicule Moteur',
	'Z'		=> 'HR Access',
	);
	
$source = 'ATS' unless $source=$ARGV[0];
	
@Cols = ('start','end','status','exit','machine','joid','run','try','application','env','alarm','alarm_time','ack','ack_time');
print "job_name	spooler_name	".join("\t",@Cols)."\n";
while (<STDIN>) {
	chomp;
	if (/\[(.*?)\]      CAUAJM_I_40245 EVENT: CHANGE_STATUS    STATUS: STARTING        JOB: (.*?) *MACHINE: (\w*)/) {
		$job = $2;
		$Last{$job} = $1;
		$runid = $Last{$job}."#".$job; 
		$Job{$runid}->{'name'} = $job;
		$Job{$runid}->{'start'} = $1;
		$Job{$runid}->{'machine'} = $3;
		$Job{$runid}->{'status'} = 'STARTING';
	}
	elsif (/\[(.*?)\]      CAUAJM_I_40245 EVENT: CHANGE_STATUS    STATUS: RUNNING         JOB: (.*?) *MACHINE: (\w*)/) {
		$job = $2; 
		$runid = $Last{$job}."#".$job; 
		$Job{$runid}->{'name'} = $job;
		$Job{$runid}->{'status'} = 'RUNNING';
	}
	elsif (/\[(.*?)\]      CAUAJM_I_10082 \[(.*?) connected for KILLJOB (.*?) (\d*)\.(\d*)\.(\d*)\]/) {
	}
	elsif (/\[(.*?)\]      CAUAJM_I_10082 \[(.*?) connected for (.*?) (\d*)\.(\d*)\.(\d*)\]/) {
		$job = $3; 
		$runid = $Last{$job}."#".$job; 
		$Job{$runid}->{'name'} = $job;
		$Job{$runid}->{'machine'} = $2;
		$Job{$runid}->{'joid'} = $4;
		$Job{$runid}->{'run'} = $5;
		$Job{$runid}->{'try'} = $6;
		$Job{$runid}->{'status'} = 'CONNECT';
	}
	#                      CAUAJM_I_40245 EVENT: CHANGE_STATUS    STATUS: SUCCESS         JOB: ORAT.RMAND.JOB.BackupInc1AgentPrimaryCheck MACHINE: xxmars          EXITCODE:  0
	elsif (/\[(.*?)\]      CAUAJM_I_40245 EVENT: CHANGE_STATUS    STATUS: ([\w_]*) *JOB: (.*?) *MACHINE: (.*?) *EXITCODE:  (\d*)/) {
		$job = $3; 		
		$runid = $Last{$job}."#".$job; 
		$Job{$runid}->{'name'} = $job;
		$Job{$runid}->{'end'} = $1;
		$Job{$runid}->{'status'} = $2;
		$Job{$runid}->{'machine'} = $4;
		$Job{$runid}->{'exit'} = $5;
	}
	# par exemple pour un terminated
	elsif (/\[(.*?)\]      CAUAJM_I_40245 EVENT: CHANGE_STATUS    STATUS: ([\w_]*) *JOB: (.*?) *MACHINE: (.*)/) {
		$job = $3; 		
		$runid = $Last{$job}."#".$job; 
		$Job{$runid}->{'name'} = $job;
		$Job{$runid}->{'end'} = $1;
		$Job{$runid}->{'status'} = $2;
		$Job{$runid}->{'machine'} = $4;
		$Job{$runid}->{'exit'} = -100;
	}
	# Sendevent sans execution
	elsif (/\[(.*?)\]      CAUAJM_I_40245 EVENT: CHANGE_STATUS    STATUS: ([\w_]*) *JOB: (.*)/) {
		$job = $3; 		
		$runid = $Last{$job}."#".$job; 
		$Job{$runid}->{'name'} = $job;
		$Job{$runid}->{'end'} = $1;
		$Job{$runid}->{'status'} = $2;
		$Job{$runid}->{'exit'} = -99; # Code pour indiquer le sendevent
	}
	elsif (/\[(.*?)\]      CAUAJM_I_40245 EVENT: ALARM            ALARM: ([\w_]*) *JOB: ([\w-\._]*?) *EXITCODE:  (\d*)/) {
		$job = $3; 		
		$runid = $Last{$job}."#".$job; 
		$Job{$runid}->{'alarm'} = $2;
		$Job{$runid}->{'alarm_time'} = $1;
		$Job{$runid}->{'exit'} = $4; 
	}
	elsif (/\[(.*?)\]      CAUAJM_I_40245 EVENT: ALARM            ALARM: ([\w_]*) *JOB: ([\w-\._]*)/) {
		$job = $3; 		
		$runid = $Last{$job}."#".$job; 
		$Job{$runid}->{'alarm'} = $2;
		$Job{$runid}->{'alarm_time'} = $1;
	}
	# JIRA
	elsif (/\[(.*?)\]      CAUAJM_I_40245 EVENT: SET_GLOBAL       GLOBAL: JIRA-(.*?) = ([\w-\._]*)/) {
		$job = $2; 		
		$runid = $Last{$job}."#".$job; 
		$Job{$runid}->{'ack_time'} = $1;
		$Job{$runid}->{'ack'} = $3;
	}	
	# Champs optionnels envoyés à travers un set_global
	elsif (/\[(.*?)\]      CAUAJM_I_40245 EVENT: SET_GLOBAL       GLOBAL: (.*?)##(.*?) = ([\w-\._]*)/) {
		$job = $3; 		
		$runid = $Last{$job}."#".$job; 
		$Job{$runid}->{$2.'_time'} = $1;
		$Job{$runid}->{$2} = $4;
	}	
}

foreach my $run (sort keys %Job) {
	DisplayJob($run);
}

sub DisplayJob {
my($runid) = @_;
	return unless $Job{$runid}->{'name'};

	# Extraction de l'application et de l'environnement
	my ($start,$job) = split('#',$runid);
	
	$info = $job;
	$info =~ s/^SE\./ADMP./;
	if ($info =~ /(\w*)(P|T|I)\./) {
		$app = $1;
		$Job{$runid}->{'env'} = $2;
	}
	if ($App{$app}) {
		$Job{$runid}->{'application'} = $App{$app};
	}
	else {
		$Job{$runid}->{'application'} = $app;
	}
	
	print "$job\t$source";
	foreach $k (@Cols) {
		print "\t".$Job{$runid}->{$k};	
	}
	print "\n";
	$Job{$runid} = (); # RAZ
}